<?php

use PHPUnit\Framework\TestCase;

require_once getcwd() . '/inc/plugins/Shinka/Core/tests/Test.php';

final class Shinka_Core_Test_Unit_Entity_SettingGroupTest extends Shinka_Core_Test_Test
{
    protected $values;

    protected function setUp()
    {
        $this->values = array(
            'name' => 'Test Name',
            'title' => 'Test Title',
            'description' => 'Test Description',
            'disporder' => 1,
            'isdefault' => 1,
            'gid' => 2
        );
    }

    public function testCreate()
    {
        $v = $this->values;
        $entity = new Shinka_Core_Entity_SettingGroup(
            $v['name'],
            $v['title'],
            $v['description'],
            $v['disporder'],
            $v['isdefault'],            
            $v['gid']
        );

        $this->assertInstanceOf(
            Shinka_Core_Entity_SettingGroup::class,
            $entity
        );

        foreach ($v as $key => $value) {
            $this->assertEquals(
                $entity->$key,
                $value
            );
        }
    }

    public function testCreateSetsDefaults()
    {
        $v = $this->values;

        $entity = new Shinka_Core_Entity_SettingGroup(
            $v['name'],
            $v['title'],
            $v['description'],
            null,
            null,
            null
        );

        $this->assertEquals(
            $entity->disporder,
            Shinka_Core_Entity_SettingGroup::DEFAULTS['disporder']
        );

        $this->assertEquals(
            $entity->isdefault,
            Shinka_Core_Entity_SettingGroup::DEFAULTS['isdefault']
        );

        $this->assertEquals(
            $entity->gid,
            Shinka_Core_Entity_SettingGroup::DEFAULTS['gid']
        );
    }

    public function testFromArray()
    {
        $v = $this->values;
        $entity = Shinka_Core_Entity_SettingGroup::fromArray($v);

        $this->assertInstanceOf(
            Shinka_Core_Entity_SettingGroup::class,
            $entity
        );

        foreach ($v as $key => $value) {
            $this->assertEquals(
                $entity->$key,
                $value
            );
        }
    }

    public function testToArray()
    {
        $v = $this->values;
        $entity = Shinka_Core_Entity_SettingGroup::fromArray($v)->toArray();
        
        unset($v['gid']);

        $this->assertEquals(
            $entity,
            $v
        );
    }
}

