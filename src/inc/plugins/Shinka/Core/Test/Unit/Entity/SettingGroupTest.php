<?php

use PHPUnit\Framework\TestCase;

require_once getcwd() . '/inc/plugins/Shinka/Core/Test/Test.php';

/**
 * @coversDefaultClass Shinka_Core_Entity_SettingGroup
 * @see     Shinka_Core_Entity_SettingGroup
 * @package Shinka\Core\Test\Unit\Entity
 */
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

    /**
     * Should set class properties correctly.
     * 
     * @test
     * @covers ::create
     */
    public function create()
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

    /**
     * Should replace `null`s with default values.
     * 
     * @test
     * @covers ::create
     */
    public function setDefaultsOnCreate()
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

    /**
     * Should correctly set class properties from array of properties.
     * 
     * @test
     * @covers ::fromArray
     */
    public function createFromArray()
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

    /**
     * Should return class properties as array.
     * 
     * @test
     * @covers ::toArray
     */
    public function convertToArray()
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

