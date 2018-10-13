<?php

require_once getcwd() . '/inc/plugins/Shinka/Core/Test/IntegrationTest.php';

/**
 * @coversDefaultClass Shinka_Core_Manager_ThreadManager
 * @see     Shinka_Core_Manager_ThreadManager
 * @package Shinka\Core\Test\Integration\Manager
 */
final class Shinka_Core_Test_Integration_Manager_ThreadManagerTest extends Shinka_Core_Test_IntegrationTest
{
    protected $table = "threads";
    protected $entity = Shinka_Core_Entity_Thread;
    protected $entities;
    protected $tids = array();
    protected $values = array();

    protected function seed()
    {
        global $db;

        for ($ndx = 0; $ndx < 5; $ndx++) {
            $entity = $this->entity(array(
                "tid" => null,
                "subject" => "Thread $ndx",
                "notes" => ""
            ));
            $this->entities[] = $entity;
            $tids = Shinka_Core_Manager_ThreadManager::create($entity);
        }
    }

    protected function setUp()
    {
        parent::setUp();
        $this->entities = array();
        $this->seed();
    }

    protected function tearDown()
    {
        global $db;
        $db->delete_query($this->table, "");
    }

    /**
     * Should persist thread.
     *
     * @test
     * @covers ::create
     */
    public function create()
    {
        $originalCount = $this->countEntities();

        Shinka_Core_Manager_ThreadManager::create($this->entities[0]);

        $newCount = $this->countEntities();

        $this->assertEquals($originalCount + 1, $newCount);
    }

    /**
     * Should return all threads.
     *
     * @test
     * @covers ::all
     */
    public function all()
    {
        $count = $this->countEntities();
        $threads = Shinka_Core_Manager_ThreadManager::all();

        $this->assertEquals($count, count($threads));
    }

    /**
     * Should return all threads.
     *
     * @test
     * @covers ::all
     */
    public function first()
    {
        $thread = Shinka_Core_Manager_ThreadManager::first();

        $this->assertEquals(true, !!$thread['tid']);
    }

    /**
     * Should destroy threads from ID.
     *
     * @test
     * @covers ::destroy
     */
    public function destroy()
    {
        $originalCount = $this->countEntities();
        $thread = Shinka_Core_Manager_ThreadManager::first();
        Shinka_Core_Manager_ThreadManager::destroy($thread['tid']);
        $newCount = $this->countEntities();

        $expected = (int) $originalCount - 1;
        $this->assertEquals($expected, (int) $newCount);
    }

    /**
     * Should destroy threads from array of prefixes.
     *
     * @test
     * @covers ::destroy
     */
    public function destroyArray()
    {
        $originalCount = $this->countEntities();
        $threads = Shinka_Core_Manager_ThreadManager::all();
        Shinka_Core_Manager_ThreadManager::destroy(
            array_map(function ($entity) {
                return $entity['tid'];
            }, $threads)
        );
        $newCount = $this->countEntities();

        $expected = (int) $originalCount - count($this->entities);
        $this->assertEquals($expected, (int) $newCount);
    }
}
