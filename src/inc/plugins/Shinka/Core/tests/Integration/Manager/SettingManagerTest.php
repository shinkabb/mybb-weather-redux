<?php

require_once getcwd() . '/inc/plugins/Shinka/Core/tests/IntegrationTest.php';

final class SettingManagerTest extends IntegrationTest
{
    protected $table = "settings";
    protected $entity = Shinka_Core_Entity_Setting;
    protected $values;
    protected $entities;
    protected $prefixes;

    protected function seed()
    {
        global $db;

        for ($ndx = 0; $ndx < 5; $ndx++) {
            $entity = $this->entity(array(
                "name" => "{$this->prefixes[0]}_$ndx"
            ));
            $this->entities[] = $entity;
            Shinka_Core_Manager_SettingManager::create($entity);
        }
    }

    protected function setUp()
    {
        parent::setUp();
        $this->values = array(
            'name' => 'test_name',
            'title' => 'Test Title',
            'description' => 'Test Description',
            'optionscode' => 'yesno',
            'value' => 'yes',
            'disporder' => 1,
            'gid' => 2
        );
        $this->entities = array();
        $this->prefixes = array("test", "another_test");
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

        Shinka_Core_Manager_SettingManager::create($this->entities[0]);

        $newCount = $this->countEntities();

        $this->assertEquals($originalCount + 1, $newCount);
    }

    public function testDestroy()
    {
        $originalCount = $this->countEntities();
        Shinka_Core_Manager_SettingManager::destroy("test");
        $newCount = $this->countEntities();

        $expected = (int) $originalCount - count($this->entities);
        $this->assertEquals($expected, (int) $newCount);
    }

    public function testDestroyArray()
    {
        $entity = $this->entity(
            array("name" => "{$this->prefixes[1]}_1")
        );
        $this->entities[] = $entity;
        Shinka_Core_Manager_SettingManager::create($entity);

        $originalCount = $this->countEntities();
        Shinka_Core_Manager_SettingManager::destroy($this->prefixes);
        $newCount = $this->countEntities();

        $expected = (int) $originalCount - count($this->entities);
        $this->assertEquals($expected, (int) $newCount);
    }
}
