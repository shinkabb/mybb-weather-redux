<?php

require_once getcwd() . '/inc/plugins/Shinka/Core/Test/IntegrationTest.php';

/**
 * @coversDefaultClass Shinka_Core_Manager_TemplateGroupManager
 * @see     Shinka_Core_Manager_TemplateGroupManager
 * @package Shinka\Core\Test\Integration\Manager
 */
final class Shinka_Core_Test_Integration_Manager_TemplateGroupManagerTest extends Shinka_Core_Test_IntegrationTest
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

    /**
     * Should persist template group from entity.
     * 
     * @test
     * @covers ::create
     */
    public function create()
    {
        $originalCount = $this->countEntities();
        Shinka_Core_Manager_TemplateGroupManager::create($this->entities[0]);
        $newCount = $this->countEntities();

        $expected = $originalCount + 1;
        $this->assertEquals($expected, $newCount);
    }

    /**
     * Should persist templates from template group entity.
     * 
     * @test
     * @covers ::create
     */
    public function createTemplates()
    {
        $entity = $this->entities[0];
        $entity->asset_dir = getcwd() . '/inc/plugins/Shinka/Core/Test/resources/templates';

        $originalCount = $this->countEntities("templates");
        Shinka_Core_Manager_TemplateGroupManager::create($entity);
        $newCount = $this->countEntities("templates");

        $expected = $originalCount + $this->countFiles($entity->asset_dir);
        $this->assertEquals($expected, $newCount);
    }

    /**
     * Should persist template groups from array of entities.
     * 
     * @test
     * @covers ::create
     */
    public function createArray()
    {
        $originalCount = $this->countEntities();
        Shinka_Core_Manager_TemplateGroupManager::create($this->entities);
        $newCount = $this->countEntities();

        $expected = $originalCount + count($this->entities);
        $this->assertEquals($expected, $newCount);
    }

    /**
     * Should destroy template group from entity.
     * 
     * @test
     * @covers ::destroy
     */
    public function destroyEntity()
    {
        $originalCount = $this->countEntities();
        Shinka_Core_Manager_TemplateGroupManager::destroy($this->entities[0]);
        $newCount = $this->countEntities();

        $expected = $originalCount - 1;
        $this->assertEquals($expected, $newCount);
    }

    /**
     * Should destroy template group from prefix.
     * 
     * @test
     * @covers ::destroy
     */
    public function destroyString()
    {
        $originalCount = $this->countEntities();
        Shinka_Core_Manager_TemplateGroupManager::destroy($this->entities[0]->prefix);
        $newCount = $this->countEntities();

        $expected = $originalCount - 1;
        $this->assertEquals($expected, $newCount);
    }

    /**
     * Should destroy template groups from array of entities.
     * 
     * @test
     * @covers ::destroy
     */
    public function destroyEntityArray()
    {
        $originalCount = $this->countEntities();
        Shinka_Core_Manager_TemplateGroupManager::destroy($this->entities);
        $newCount = $this->countEntities();

        $expected = $originalCount - count($this->entities);
        $this->assertEquals($expected, $newCount);
    }

    /**
     * Should destroy template groups from array of prefixes.
     * 
     * @test
     * @covers ::destroy
     */
    public function destroyStringArray()
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

    /**
     * Should destroy templates.
     * 
     * @test
     * @covers ::destroy
     */
    public function destroyTemplates()
    {
        $entity = $this->entity();

        $entity->asset_dir = getcwd() . '/inc/plugins/Shinka/Core/Test/resources/templates';
        Shinka_Core_Manager_TemplateGroupManager::create($entity);

        $originalCount = $this->countEntities("templates");
        Shinka_Core_Manager_TemplateGroupManager::destroy($entity);
        $newCount = $this->countEntities("templates");

        $expected = $originalCount - $this->countFiles($entity->asset_dir);
        $this->assertEquals($expected, $newCount);
    }
}
