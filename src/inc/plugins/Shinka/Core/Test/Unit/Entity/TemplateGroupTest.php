<?php

use PHPUnit\Framework\TestCase;

require_once getcwd() . '/inc/plugins/Shinka/Core/Test/Test.php';

/**
 * @coversDefaultClass Shinka_Core_Entity_TemplateGroup
 * @see     Shinka_Core_Entity_TemplateGroup
 * @package Shinka\Core\Test\Unit\Entity
 */
final class Shinka_Core_Test_Unit_Entity_TemplateGroupTest extends Shinka_Core_Test_Test
{
    protected $values;

    protected function setUp()
    {
        parent::setUp();
        $this->values = array(
            'asset_dir' => 'Test Name',
            'prefix' => 'Test prefix',
            'title' => 'Test title',
            'isdefault' => 1
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
        $entity = new Shinka_Core_Entity_TemplateGroup(
            $v['asset_dir'],
            $v['prefix'],
            $v['title'],
            $v['isdefault']
        );

        $this->assertInstanceOf(
            Shinka_Core_Entity_TemplateGroup::class,
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
        $entity = new Shinka_Core_Entity_TemplateGroup(
            $v['asset_dir'],
            $v['prefix'],
            $v['title'],
            null
        );

        $this->assertEquals(
            $entity->isdefault,
            Shinka_Core_Entity_TemplateGroup::DEFAULTS['isdefault']
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
        $entity = Shinka_Core_Entity_TemplateGroup::fromArray($v);

        $this->assertInstanceOf(
            Shinka_Core_Entity_TemplateGroup::class,
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
        $entity = Shinka_Core_Entity_TemplateGroup::fromArray($v)->toArray();

        // asset_dir not included in array
        unset($v['asset_dir']);

        $this->assertEquals(
            $entity,
            $v
        );
    }
}

