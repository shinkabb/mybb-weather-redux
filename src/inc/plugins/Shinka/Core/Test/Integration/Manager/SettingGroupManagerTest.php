<?php

require_once getcwd() . '/inc/plugins/Shinka/Core/Test/IntegrationTest.php';

/**
 * @coversDefaultClass Shinka_Core_Manager_SettingGroupManager
 * @see     Shinka_Core_Manager_SettingGroupManager
 * @package Shinka\Core\Test\Integration\Manager
 */
final class Shinka_Core_Test_Integration_Manager_SettingGroupManagerTest extends Shinka_Core_Test_IntegrationTest
{
    protected $table = "settinggroups";
    protected $entity = Shinka_Core_Entity_SettingGroup;
    protected $values;
    protected $entities = array();

    /**
     * Seeds setting groups.
     */
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

    /**
     * Truncates table.
     */
    protected function tearDown()
    {
        global $db;
        $db->delete_query($this->table, "");
    }

    /**
     * Should persist a setting group in the database.
     * 
     * @test
     * @covers ::create
     */
    public function create()
    {
        $originalCount = $this->countEntities();

        Shinka_Core_Manager_SettingGroupManager::create($this->entities[0]);

        $newCount = $this->countEntities();

        $this->assertEquals($originalCount + 1, $newCount);
    }

    /**
     * Should destroy a setting group from entity.
     * 
     * @test
     * @covers ::destroy
     */
    public function destroyEntity()
    {
        $originalCount = $this->countEntities();
        Shinka_Core_Manager_SettingGroupManager::destroy($this->entities[0]);
        $newCount = $this->countEntities();

        $expected = (int) $originalCount - 1;
        $this->assertEquals($expected, (int) $newCount);
    }

    /**
     * Should destroy a setting group from name.
     * 
     * @test
     * @covers ::destroy
     */
    public function destroyString()
    {
        $originalCount = $this->countEntities();
        Shinka_Core_Manager_SettingGroupManager::destroy($this->entities[0]->name);
        $newCount = $this->countEntities();

        $expected = (int) $originalCount - 1;
        $this->assertEquals($expected, (int) $newCount);
    }

    /**
     * Should destroy setting groups from array of entities.
     * 
     * @test
     * @covers ::destroy
     */
    public function destroyEntityArray()
    {
        $originalCount = $this->countEntities();
        Shinka_Core_Manager_SettingGroupManager::destroy($this->entities);
        $newCount = $this->countEntities();

        $expected = (int) $originalCount - count($this->entities);
        $this->assertEquals($expected, (int) $newCount);
    }

    /**
     * Should destroy setting groups from array of names.
     * 
     * @test
     * @covers ::destroy
     */
    public function destroyStringArray()
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
