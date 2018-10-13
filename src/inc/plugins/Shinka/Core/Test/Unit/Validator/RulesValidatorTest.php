<?php

use PHPUnit\Framework\TestCase;

require_once getcwd() . '/inc/plugins/Shinka/Core/Test/Test.php';
/**
 * @coversDefaultClass Shinka_Core_Validator_RulesValidator
 * @see     Shinka_Core_Validator_RulesValidator
 * @package Shinka\Core\Test\Unit\Validator
 */
final class Shinka_Core_Test_Unit_Validator_RulesValidatorTest extends Shinka_Core_Test_Test
{
    protected $entity;
    protected $rules;

    /**
     * In format <c>array(value)</c>.
     * @return array
     */
    public function dataValidRequired() {
        return array(
            "Valid when not blank" => array("hello world", true), 
            "Valid when falsy" => array(0, true),
            "Invalid when null" => array(null, false), 
            "Invalid when blank" => array("", false)
        );
    }

    /**
     * In format <c>array(value, expected)</c>.
     * @return array
     */
    public function dataRequiredErrors() {
        return array(
            "Valid when not blank" => array("hello world", array()), 
            "Valid when falsy" => array(0, array()),
            "Invalid when null" => array(null, array("required")), 
            "Invalid when blank" => array("", array("required"))
        );
    }

    /**
     * In format <c>array(value)</c>.
     * @return array
     */
    public function dataExists() {
        return array(
            "Invalid when null" => array(null), 
            "Invalid when blank" => array("")
        );
    }

    /**
     * In format <c>array(value)</c>.
     * @return array
     */
    public function dataShapeExists() {
        return array(
            // array(rule, property, expected)
            array(
                array("exists"), 
                "property", 
                array("table" => "property", "primaryKey" => "id")
            ), 
            array(
                array("exists", "forums"), 
                "property", 
                array("table" => "forums", "primaryKey" => "id")
            ), 
            array(
                array("exists", "forums", "fid"), 
                "property", 
                array("table" => "forums", "primaryKey" => "fid")
            ), 
        );
    }

    /**
     * In format <c>array(entity, property, expected)</c>.
     * @return array
     */
    public function dataGetValue() {
        return array(
            array(
                array("thread" => "a thread"),
                "thread",
                "a thread"
            ), 
            array(
                array("thread" => (object) array("tid" => 999)),
                "thread.tid",
                999
            ), 
        );
    }

    protected function setUp() {
        parent::setUp();
        $this->entity = new Shinka_Core_Entity_Entity();
        $this->rules = array();
    }

    /**
     * Shorthand to call rules validator.
     * 
     * @see Shinka_Core_Validator_RulesValidator::validate
     * @param Shinka_Core_Entity_Entity $entity
     * @return boolean
     */
    protected function validate($entity = null) {
        return Shinka_Core_Validator_RulesValidator::validate(
            $this->entity, $this->rules
        );
    }

    /**
     * @test
     * @covers ::isValid
     * @dataProvider dataValidRequired
     */
    public function validateRequired($value, $expected) {
        $this->rules = array(
            "property" => "required"
        );
        $this->entity->property = $value;
        $valid = $this->validate();
        $this->assertEquals($expected, $valid);
    }

    /**
     * @test
     * @covers ::checkRule
     * @dataProvider dataRequiredErrors
     */
    public function checkRuleRequired($value, $expected) {
        $errors = Shinka_Core_Validator_RulesValidator::checkRule(
            "property", $value, "required"
        );
        $this->assertEquals($expected, $errors);
    }

    /**
     * @test
     * @covers ::checkRequired
     * @dataProvider dataValidRequired
     */
    public function checkRequired($value, $expected) {
        $valid = Shinka_Core_Validator_RulesValidator::checkRequired($value);
        $this->assertEquals($expected, $valid);
    }

    /**
     * @test
     * @covers ::shapeExistsRule
     * @dataProvider dataShapeExists
     */
    public function shapeExistsRule($rule, $property, $expected) {
        $valid = Shinka_Core_Validator_RulesValidator::shapeExistsRule($rule, $property);
        $this->assertEquals($expected, $valid);
    }

    /**
     * @test
     * @covers ::getValue
     * @dataProvider dataGetValue
     */
    public function getValue($entity, $property, $expected) {
        $entity = (object) $entity;
        $value = Shinka_Core_Validator_RulesValidator::getValue($entity, $property);
        $this->assertEquals($expected, $value);
    }
}

