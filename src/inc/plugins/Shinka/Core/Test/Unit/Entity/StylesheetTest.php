<?php

use PHPUnit\Framework\TestCase;

require_once getcwd() . '/inc/plugins/Shinka/Core/Test/Test.php';

/**
 * @coversDefaultClass Shinka_Core_Entity_Stylesheet
 * @see     Shinka_Core_Entity_Stylesheet
 * @package Shinka\Core\Test\Unit\Entity
 */
final class Shinka_Core_Test_Unit_Entity_StylesheetTest extends Shinka_Core_Test_Test
{
    protected $values;

    protected function setUp()
    {
        parent::setUp();
        $this->values = array(
            'stylesheet' => 'Test stylesheet',
            'name' => 'Test Name',
            'attachedto' => 'Test attachment',
            'tid' => 2
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
        $entity = new Shinka_Core_Entity_Stylesheet(
            $v['stylesheet'],
            $v['name'],
            $v['attachedto'],
            $v['tid']
        );

        $this->assertInstanceOf(
            Shinka_Core_Entity_Stylesheet::class,
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

        $entity = new Shinka_Core_Entity_Stylesheet(
            $v['stylesheet'],
            $v['name'],
            null,
            null
        );

        $this->assertEquals(
            $entity->attachedto,
            Shinka_Core_Entity_Stylesheet::DEFAULTS['attachedto']
        );

        $this->assertEquals(
            $entity->tid,
            Shinka_Core_Entity_Stylesheet::DEFAULTS['tid']
        );
    }

    /**
     * Should create entities for each file in an asset directory.
     * 
     * @test
     * @covers ::fromDirectory
     */
    public function createFromDirectory()
    {
        $entities = Shinka_Core_Entity_Stylesheet::fromDirectory(MYBB_ROOT . "inc/plugins/Shinka/Core/Test/resources/stylesheets");

        foreach ($entities as $ndx => $entity) {
            $this->assertInstanceOf(
                Shinka_Core_Entity_Stylesheet::class,
                $entity
            );

            $this->assertEquals(
                $entity->name,
                "$ndx-name.html"
            );

            $this->assertEquals(
                $entity->stylesheet,
                "$ndx-contents"
            );
        }
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
        $entity = Shinka_Core_Entity_Stylesheet::fromArray($v);

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
        $entity = new Shinka_Core_Entity_Stylesheet(
            $v['stylesheet'],
            $v['name'],
            $v['attachedto'],
            $v['tid']
        );

        $this->assertEquals(
            $entity->toArray(),
            $v
        );
    }
}

