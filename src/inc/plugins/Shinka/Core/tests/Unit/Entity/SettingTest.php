<?php

use PHPUnit\Framework\TestCase;

require_once getcwd() . '/inc/plugins/Shinka/Core/tests/Test.php';

final class SettingTest extends Test
{
    protected $values;

    protected function setUp()
    {
        $this->values = array(
            'name' => 'Test Name',
            'title' => 'Test Title',
            'description' => 'Test Description',
            'optionscode' => 'yesno',
            'value' => 'yes',
            'disporder' => 1,
            'gid' => 2
        );
    }

    public function testCreate()
    {
        $v = $this->values;
        $entity = new Shinka_Core_Entity_Setting(
            $v['name'],
            $v['title'],
            $v['description'],
            $v['optionscode'],
            $v['value'],
            $v['disporder'],
            $v['gid']
        );

        $this->assertInstanceOf(
            Shinka_Core_Entity_Setting::class,
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

        $entity = new Shinka_Core_Entity_Setting(
            $v['name'],
            $v['title'],
            $v['description'],
            $v['optionscode'],
            $v['value'],
            null,
            null
        );

        $this->assertEquals(
            $entity->disporder,
            Shinka_Core_Entity_Setting::DEFAULTS['disporder']
        );

        $this->assertEquals(
            $entity->gid,
            Shinka_Core_Entity_Setting::DEFAULTS['gid']
        );
    }

    public function testFromArray()
    {
        $v = $this->values;
        $entity = Shinka_Core_Entity_Setting::fromArray($v);

        $this->assertInstanceOf(
            Shinka_Core_Entity_Setting::class,
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
        $entity = Shinka_Core_Entity_Setting::fromArray($v)->toArray();

        $this->assertEquals(
            $entity,
            $v
        );
    }
}

