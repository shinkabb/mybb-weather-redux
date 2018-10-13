<?php

use PHPUnit\Framework\TestCase;

require_once getcwd() . '/inc/plugins/Shinka/Core/Test/Test.php';

/**
 * @coversDefaultClass Shinka_Core_Entity_Entity
 * @see     Shinka_Core_Entity_Entity
 * @package Shinka\Core\Test\Unit\Entity
 */
final class Shinka_Core_Test_Unit_Entity_EntityTest extends Shinka_Core_Test_Test
{
    public function dataIsValid() {
        return array(
            array("hello world", "required", true),
            array(0, "required", true),
            array("", "required", false),
            array(null, "required", false),
        );
    }

    protected function tearDown() {
        Shinka_Core_Entity_Entity::$validate = null;
    }

    /**
     * @test
     * @covers ::create
     */
    public function create()
    {
        $entity = new Shinka_Core_Entity_Entity();
        $this->assertInstanceOf(
            Shinka_Core_Entity_Entity::class,
            $entity
        );
    }

    /**
     * Should replace null values with defaults.
     *
     * @test
     * @covers ::create
     */
    public function setDefaults()
    {
        $defaults = array(
            "one" => 1,
            "two" => "2"
        );

        $entity = new Shinka_Core_Entity_Entity();
        $entity->setDefaults($defaults);

        foreach ($defaults as $key => $value)
        {
            $this->assertEquals(
                $entity->$key,
                $value
            );
        }
    }

    /**
     * Should return true when no validation rules.
     *
     * @test
     * @covers ::isValid
     */
    public function isValidEmpty()
    {
        $entity = new Shinka_Core_Entity_Entity();
        $this->assertTrue($entity->isValid());
    }

    /**
     * Should return true when no validation rules.
     *
     * @test
     * @covers ::isValid
     */
    public function isValidEmptyArray()
    {
        Shinka_Core_Entity_Entity::$validate = array();
        $entity = new Shinka_Core_Entity_Entity();
        $this->assertTrue($entity->isValid());
    }

    /**
     * Should return true when validation rules
     * are met.
     *
     * @test
     * @dataProvider dataIsValid
     * @covers ::isValid
     */
    public function isValid($value, $rule, $expected)
    {
        Shinka_Core_Entity_Entity::$validate = array(
            "property" => $rule
        );
        $entity = new Shinka_Core_Entity_Entity();
        $entity->property = $value;
        $this->assertEquals($expected, $entity->isValid());
    }
}

