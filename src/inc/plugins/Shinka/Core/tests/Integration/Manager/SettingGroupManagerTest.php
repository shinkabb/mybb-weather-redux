<?php

require_once getcwd() . '/inc/plugins/Shinka/Core/tests/IntegrationTest.php';

final class Shinka_Core_Test_Integration_Manager_SettingGroupManagerTest extends Shinka_Core_Test_IntegrationTest
{
    protected $table = "settinggroups";
    protected $entity = Shinka_Core_Entity_SettingGroup;
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
            Shinka_Core_Manager_SettingGroupManager::create($entity);
        }
    }

    protected function setUp()
    {
        parent::setUp();
        $this->values = array(
            'name' => 'Test Name 1',
            'title' => 'Test Title',
            'description' => 'Test Description',
            'disporder' => 1,
            'isdefault' => 1,
        );
        
        $this->seed();
    }

    protected function tearDown()
    {
        global $db;
        $db->delete_query($this->table, "");
    }

    public function testCreate()
    {
        $originalCount = $this->countEntities();

        Shinka_Core_Manager_SettingGroupManager::create($this->entities[0]);

        $newCount = $this->countEntities();

        $this->assertEquals($originalCount + 1, $newCount);
    }

    public function testDestroyEntity()
    {
        $originalCount = $this->countEntities();
        Shinka_Core_Manager_SettingGroupManager::destroy($this->entities[0]);
        $newCount = $this->countEntities();

        $expected = (int) $originalCount - 1;
        $this->assertEquals($expected, (int) $newCount);
    }

    public function testDestroyString()
    {
        $originalCount = $this->countEntities();
        Shinka_Core_Manager_SettingGroupManager::destroy($this->entities[0]->name);
        $newCount = $this->countEntities();

        $expected = (int) $originalCount - 1;
        $this->assertEquals($expected, (int) $newCount);
    }

    public function testDestroyEntityArray()
    {
        $originalCount = $this->countEntities();
        Shinka_Core_Manager_SettingGroupManager::destroy($this->entities);
        $newCount = $this->countEntities();

        $expected = (int) $originalCount - count($this->entities);
        $this->assertEquals($expected, (int) $newCount);
    }

    public function testDestroyStringArray()
    {
        $entities = array_map(function ($entity) {
            return $entity->name;
        }, $this->entities);

        $originalCount = $this->countEntities();
        Shinka_Core_Manager_SettingGroupManager::destroy($entities);
        $newCount = $this->countEntities();

        $expected = (int) $originalCount - count($entities);
        $this->assertEquals($expected, (int) $newCount);
    }
}
