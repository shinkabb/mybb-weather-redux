<?php

require_once getcwd() . '/inc/plugins/Shinka/Core/Test/IntegrationTest.php';

/**
 * @coversDefaultClass Shinka_Core_Manager_StylesheetManager
 * @see     Shinka_Core_Manager_StylesheetManager
 * @package Shinka\Core\Test\Integration\Manager
 */
final class Shinka_Core_Test_Integration_Manager_StylesheetManagerTest extends Shinka_Core_Test_IntegrationTest
{
    protected $table = "themestylesheets";
    protected $entity = Shinka_Core_Entity_Stylesheet;
    protected $values;
    protected $entities = array();

    protected function seed()
    {
        global $db;

        for ($ndx = 0; $ndx < 5; $ndx++) {
            $entity = $this->entity(array(
                "name" => "Test Name $ndx"
            ));
            $this->entities[] = $entity;
            Shinka_Core_Manager_StylesheetManager::create($entity);
        }
    }

    protected function setUp()
    {
        parent::setUp();
        $this->values = array(
            'stylesheet' => '<b>hello world</b>',
            'sanitized' => '\<b\>hello world \</b\>',
            'name' => 'Test Name',
            'attachedto' => 'Test attachment',
            'tid' => 1
        );
        
        $this->seed();
    }

    protected function tearDown()
    {
        global $db;
        $db->delete_query($this->table, "");
    }

    /**
     * Should persist stylesheet from entity.
     * 
     * @test
     * @covers ::create
     */
    public function create()
    {
        global $db;

        $originalCount = $this->countEntities();
        Shinka_Core_Manager_StylesheetManager::create($this->entities[0]);
        $newCount = $this->countEntities();

        $this->assertEquals($originalCount + 1, $newCount);
    }

    /**
     * Should persist stylesheets from array of entity.
     * 
     * @test
     * @covers ::create
     */
    public function createArray()
    {
        global $db;

        $originalCount = $this->countEntities();
        Shinka_Core_Manager_StylesheetManager::create($this->entities);
        $newCount = $this->countEntities();

        $this->assertEquals($originalCount + count($this->entities), $newCount);
    }

    /**
     * Should destroy stylesheet from entity.
     * 
     * @test
     * @covers ::create
     */
    public function testDestroyEntity()
    {
        $originalCount = $this->countEntities();
        Shinka_Core_Manager_StylesheetManager::destroy($this->entities[0]);
        $newCount = $this->countEntities();

        $expected = (int) $originalCount - 1;
        $this->assertEquals($expected, (int) $newCount);
    }

    /**
     * Should destroy stylesheets from array of entities.
     * 
     * @test
     * @covers ::create
     */
    public function testDestroyEntityArray()
    {
        $originalCount = $this->countEntities();
        Shinka_Core_Manager_StylesheetManager::destroy($this->entities);
        $newCount = $this->countEntities();

        $expected = (int) $originalCount - count($this->entities);
        $this->assertEquals($expected, (int) $newCount);
    }
}
