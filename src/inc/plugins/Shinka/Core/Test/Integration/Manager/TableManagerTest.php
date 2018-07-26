<?php

require_once getcwd() . '/inc/plugins/Shinka/Core/Test/IntegrationTest.php';

final class Shinka_Core_Test_Integration_Manager_TableManagerTest extends Shinka_Core_Test_IntegrationTest
{
    protected $entity = Shinka_Core_Entity_Table;
    /** @var array */
    protected $values;
    /** @var Shinka_Core_Entity_Table[] */
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

    public function testCreate()
    {
        global $db;

        Shinka_Core_Manager_TableManager::create($this->entities[0]);

        $exists = $db->table_exists($this->entities[0]->name);
        $this->assertTrue($exists);
    }

    public function testCreateArray()
    {
        global $db;

        Shinka_Core_Manager_TableManager::create($this->entities);

        $exists = $db->table_exists($this->entities[0]->name);
        $this->assertTrue($exists);
    }

    public function testCreateAlreadyExists()
    {
        global $db;

        Shinka_Core_Manager_TableManager::create($this->entities[0]);
        $exit = Shinka_Core_Manager_TableManager::create($this->entities[0]);

        $this->assertEquals($exit, -1);
    }

    public function testDropEntity()
    {
        global $db;
        
        Shinka_Core_Manager_TableManager::create($this->entities[0]);
        Shinka_Core_Manager_TableManager::drop($this->entities[0]);

        $exists = $db->table_exists($this->entity()->name);
        $this->assertFalse($exists);
    }

    public function testDropString()
    {
        global $db;
        
        Shinka_Core_Manager_TableManager::create($this->entities[0]);
        Shinka_Core_Manager_TableManager::drop($this->entities[0]->name);

        $exists = $db->table_exists($this->entity()->name);
        $this->assertFalse($exists);
    }

    public function testDropEntityArray()
    {
        global $db;
        
        Shinka_Core_Manager_TableManager::create($this->entities);
        Shinka_Core_Manager_TableManager::drop($this->entities);

        foreach ($this->entities as $entity) {
            $exists = $db->table_exists($entity->name);
            $this->assertFalse($exists);
        }
    }

    public function testDropStringArray()
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
