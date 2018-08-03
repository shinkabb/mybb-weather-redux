<?php

require_once getcwd() . '/inc/plugins/Shinka/Core/Test/IntegrationTest.php';

/**
 * @coversDefaultClass Shinka_Core_Manager_TableManager
 * @see     Shinka_Core_Manager_TableManager
 * @package Shinka\Core\Test\Integration\Manager
 */
final class Shinka_Core_Test_Integration_Manager_TableManagerTest extends Shinka_Core_Test_IntegrationTest
{
    protected $entity = Shinka_Core_Entity_Table;
    protected $values;
    protected $entities;

    protected function setUp()
    {
        parent::setUp();
        $this->values = array(
            'name' => 'test_1',
            'definitions' => array(
                '`tid` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT',
                '`text` VARCHAR(255)',
                'PRIMARY KEY (`tid`)',
            ),
        );
        $this->entities = array(
            $this->entity(),
            $this->entity(array(
                'name' => 'test_2',
            )));
    }

    protected function tearDown()
    {
        global $db;
        foreach ($this->entities as $entity) {
            $db->drop_table($entity->name);
        }
    }

    /**
     * Should create table from entity.
     * 
     * @test
     * @covers ::create
     */
    public function create()
    {
        global $db;

        Shinka_Core_Manager_TableManager::create($this->entities[0]);

        $exists = $db->table_exists($this->entities[0]->name);
        $this->assertTrue($exists);
    }

    /**
     * Should create tables from array of entities.
     * 
     * @test
     * @covers ::create
     */
    public function createArray()
    {
        global $db;

        Shinka_Core_Manager_TableManager::create($this->entities);

        $exists = $db->table_exists($this->entities[0]->name);
        $this->assertTrue($exists);
    }

    /**
     * Should not break if table already exists.
     * 
     * @test
     * @covers ::create
     */
    public function createAlreadyExists()
    {
        global $db;

        Shinka_Core_Manager_TableManager::create($this->entities[0]);
        $exit = Shinka_Core_Manager_TableManager::create($this->entities[0]);

        $this->assertEquals($exit, -1);
    }

    /**
     * Should drop table from entity.
     * 
     * @test
     * @covers ::drop
     */
    public function dropEntity()
    {
        global $db;
        
        Shinka_Core_Manager_TableManager::create($this->entities[0]);
        Shinka_Core_Manager_TableManager::drop($this->entities[0]);

        $exists = $db->table_exists($this->entity()->name);
        $this->assertFalse($exists);
    }

    /**
     * Should drop table from table name.
     * 
     * @test
     * @covers ::drop
     */
    public function dropString()
    {
        global $db;
        
        Shinka_Core_Manager_TableManager::create($this->entities[0]);
        Shinka_Core_Manager_TableManager::drop($this->entities[0]->name);

        $exists = $db->table_exists($this->entity()->name);
        $this->assertFalse($exists);
    }

    /**
     * Should drop table from array of entities.
     * 
     * @test
     * @covers ::drop
     */
    public function dropEntityArray()
    {
        global $db;
        
        Shinka_Core_Manager_TableManager::create($this->entities);
        Shinka_Core_Manager_TableManager::drop($this->entities);

        foreach ($this->entities as $entity) {
            $exists = $db->table_exists($entity->name);
            $this->assertFalse($exists);
        }
    }

    /**
     * Should drop table from array of table names.
     * 
     * @test
     * @covers ::drop
     */
    public function dropStringArray()
    {
        global $db;

        $entities = array_map(function ($entity) {
            return $entity->name;
        }, $this->entities);

        Shinka_Core_Manager_TableManager::create($this->entities);
        Shinka_Core_Manager_TableManager::drop($entities);

        foreach ($this->entities as $entity) {
            $exists = $db->table_exists($entity->name);
            $this->assertFalse($exists);
        }
    }
}
