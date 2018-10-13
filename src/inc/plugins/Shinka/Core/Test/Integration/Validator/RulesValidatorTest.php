<?php

use PHPUnit\Framework\TestCase;

require_once getcwd() . '/inc/plugins/Shinka/Core/Test/IntegrationTest.php';
require_once getcwd() . '/inc/plugins/Shinka/Core/Test/Fixture/Fixture.php';

/**
 * @coversDefaultClass Shinka_Core_Validator_RulesValidator
 * @see     Shinka_Core_Validator_RulesValidator
 * @package Shinka\Core\Test\Unit\Validator
 */
final class Shinka_Core_Test_Integration_Validator_RulesValidatorTest extends Shinka_Core_Test_IntegrationTest
{
    protected $entity;
    protected $rules;
    protected $rule;

    /**
     * In format <c>array(tid, expected)</c>.
     */
    public function dataThreadIDs() {
        return array(
            "Thread exists" => array(1, 1), 
            "Thread does not exist" => array(999, 0)
        );
    }

    /**
     * In format <c>array(tid, expected)</c>.
     */
    public function dataCheckRule() {
        return array(
            "Thread exists" => array(
                1, array()
            ), 
            "Thread does not exist" => array(999, array("exists"))
        );
    }

    /**
     * In format <c>array(tid, rule, expected)</c>.
     */
    public function dataValidate() {
        return array(
            array(1, "exists:threads:tid", true),
            array(999, "exists:threads:tid", false),
        );
    }

    /**
     * Seeds thread with <c>tid</c> 1.
     */
    protected function seed()
    {
        global $db;

        $db->insert_query("threads", Shinka_Core_Test_Fixture_Fixture::thread(array(
            'tid' => 1
        )));
    }

    /**
     * Seeds thread and sets default entity and rule.
     *
     * @return void
     */
    protected function setUp() {
        parent::setUp();
        $this->entity = new Shinka_Core_Entity_Entity();
        $this->rules = array();
        $this->rule = array("exists", "threads", "tid");
        $this->seed();
    }

    /**
     * Deletes seeded thread from database.
     *
     * @return void
     */
    protected function tearDown() {
        global $db;
        $db->delete_query("threads", "");
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
            $entity ?: $this->entity, $this->rules
        );
    }

    /**
     * @test
     * @dataProvider dataThreadIDs
     * @covers ::checkExists
     */
    public function checkExists($tid, $expected) {
        $count = Shinka_Core_Validator_RulesValidator::checkExists("tid", $tid, $this->rule);
        $this->assertEquals($expected, $count);
    }

    /**
     * @test
     * @covers ::checkRule
     * @dataProvider dataCheckRule
     */
    public function checkRuleCaseExists($value, $expected) {
        $this->rule = "exists:threads:tid";
        $this->entity->property = $value;
        $errors = Shinka_Core_Validator_RulesValidator::checkRule("property", $value, $this->rule);
        $this->assertEquals($expected, $errors);
    }

    /**
     * @test
     * @covers ::validate
     * @dataProvider dataValidate
     */
    public function validateThread($value, $rule, $expected) {
        $this->entity->property = $value;
        $this->rules = array("property" => $rule);
        $valid = Shinka_Core_Validator_RulesValidator::validate($this->entity, $this->rules);
        $this->assertEquals($expected, $valid);
    }
}

