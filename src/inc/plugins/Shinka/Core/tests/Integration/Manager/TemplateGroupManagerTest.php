<?php

require_once getcwd() . '/inc/plugins/Shinka/Core/tests/IntegrationTest.php';

final class TemplateGroupManagerTest extends IntegrationTest
{
    protected $table = "templategroups";
    protected $entity = Shinka_Core_Entity_TemplateGroup;
    protected $values;
    protected $entities;

    protected function seed()
    {
        global $db;

        for ($ndx = 0; $ndx < 5; $ndx++) {
            $entity = $this->entity(array(
                "name" => "Test Name $ndx",
                "prefix" => "{$ndx}_prefix"
            ));
            $this->entities[] = $entity;
            Shinka_Core_Manager_TemplateGroupManager::create($entity);
        }
    }

    protected function setUp()
    {
        parent::setUp();
        $this->values = array(
            'asset_dir' => "",
            'prefix' => 'prefix',
            'title' => 'Test title',
            'isdefault' => 1
        );
        $this->entities = array();
        $this->seed();
    }

    protected function tearDown()
    {
        global $db;
        $db->delete_query($this->table, "");
        $db->delete_query("templates", "");
    }

    public function testCreate()
    {
        $originalCount = $this->countEntities();
        Shinka_Core_Manager_TemplateGroupManager::create($this->entities[0]);
        $newCount = $this->countEntities();

        $expected = $originalCount + 1;
        $this->assertEquals($expected, $newCount);
    }

    public function testCreateTemplates()
    {
        $entity = $this->entities[0];
        $entity->asset_dir = getcwd() . '/inc/plugins/Shinka/Core/tests/data/templates';

        $originalCount = $this->countEntities("templates");
        Shinka_Core_Manager_TemplateGroupManager::create($entity);
        $newCount = $this->countEntities("templates");

        $expected = $originalCount + $this->countFiles($entity->asset_dir);
        $this->assertEquals($expected, $newCount);
    }

    public function testCreateArray()
    {
        $originalCount = $this->countEntities();
        Shinka_Core_Manager_TemplateGroupManager::create($this->entities);
        $newCount = $this->countEntities();

        $expected = $originalCount + count($this->entities);
        $this->assertEquals($expected, $newCount);
    }

    public function testDestroyEntity()
    {
        $originalCount = $this->countEntities();
        Shinka_Core_Manager_TemplateGroupManager::destroy($this->entities[0]);
        $newCount = $this->countEntities();

        $expected = $originalCount - 1;
        $this->assertEquals($expected, $newCount);
    }

    public function testDestroyString()
    {
        $originalCount = $this->countEntities();
        Shinka_Core_Manager_TemplateGroupManager::destroy($this->entities[0]->prefix);
        $newCount = $this->countEntities();

        $expected = $originalCount - 1;
        $this->assertEquals($expected, $newCount);
    }

    public function testDestroyEntityArray()
    {
        $originalCount = $this->countEntities();
        Shinka_Core_Manager_TemplateGroupManager::destroy($this->entities);
        $newCount = $this->countEntities();

        $expected = $originalCount - count($this->entities);
        $this->assertEquals($expected, $newCount);
    }

    public function testDestroyStringArray()
    {
        $entities = array_map(function ($entity) {
            return $entity->prefix;
        }, $this->entities);

        $originalCount = $this->countEntities();
        Shinka_Core_Manager_TemplateGroupManager::destroy($entities);
        $newCount = $this->countEntities();

        $expected = $originalCount - count($entities);
        $this->assertEquals($expected, $newCount);
    }

    public function testDestroyTemplates()
    {
        $entity = $this->entity();

        $entity->asset_dir = getcwd() . '/inc/plugins/Shinka/Core/tests/data/templates';
        Shinka_Core_Manager_TemplateGroupManager::create($entity);

        $originalCount = $this->countEntities("templates");
        Shinka_Core_Manager_TemplateGroupManager::destroy($entity);
        $newCount = $this->countEntities("templates");

        $expected = $originalCount - $this->countFiles($entity->asset_dir);
        $this->assertEquals($expected, $newCount);
    }
}
