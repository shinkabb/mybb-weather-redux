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
     * @covers ::isValid
     */
    public function isValidWhenRequired()
    {
        Shinka_Core_Entity_Entity::$validate = array(
            "property" => "required"
        );
        $entity = new Shinka_Core_Entity_Entity();
        $entity->property = "hello world";
        $this->assertFalse($entity->isValid());
    }

    /**
     * Should return false when null.
     *
     * @test
     * @covers ::isValid
     */
    public function isNotValidWhenRequiredNull()
    {
        Shinka_Core_Entity_Entity::$validate = array(
            "property" => "required"
        );
        $entity = new Shinka_Core_Entity_Entity();
        $this->assertFalse($entity->isValid());
    }

    /**
     * Should return false when blank.
     *
     * @test
     * @covers ::isValid
     */
    public function isNotValidWhenRequiredBlank()
    {
        Shinka_Core_Entity_Entity::$validate = array(
            "property" => "required"
        );
        $entity = new Shinka_Core_Entity_Entity();
        $entity->property = "";
        $this->assertFalse($entity->isValid());
    }

    /**
     * Should return true when falsy but not null or blank.
     *
     * @test
     * @covers ::isValid
     */
    public function isValidWhenRequiredFalsy()
    {
        Shinka_Core_Entity_Entity::$validate = array(
            "property" => "required"
        );
        $entity = new Shinka_Core_Entity_Entity();
        $entity->property = 0;
        $this->assertFalse($entity->isValid());
    }
}

