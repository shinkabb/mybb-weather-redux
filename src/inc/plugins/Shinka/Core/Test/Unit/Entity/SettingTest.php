<?php

use PHPUnit\Framework\TestCase;

require_once getcwd() . '/inc/plugins/Shinka/Core/Test/Test.php';

/**
 * @coversDefaultClass Shinka_Core_Entity_Setting
 * @see     Shinka_Core_Entity_Setting
 * @package Shinka\Core\Test\Unit\Entity
 */
final class Shinka_Core_Test_Unit_Entity_SettingTest extends Shinka_Core_Test_Test
{
    protected $values;

    protected function setUp()
    {
        parent::setUp();
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

    /**
     * Should set class properties correctly.
     * 
     * @test
     * @covers ::create
     */
    public function create()
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

    /**
     * Should replace `null`s with default values.
     * 
     * @test
     * @covers ::create
     */
    public function setDefaultsOnCreate()
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

    /**
     * Should correctly set class properties from array of properties.
     * 
     * @test
     * @covers ::fromArray
     */
    public function createFromArray()
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

    /**
     * Should return class properties as array.
     * 
     * @test
     * @covers ::toArray
     */
    public function convertToArray()
    {
        $v = $this->values;
        $entity = Shinka_Core_Entity_Setting::fromArray($v)->toArray();

        $this->assertEquals(
            $entity,
            $v
        );
    }
}

