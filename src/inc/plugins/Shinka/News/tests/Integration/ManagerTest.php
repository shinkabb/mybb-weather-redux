<?php

require_once getcwd() . '/inc/plugins/Shinka/Core/tests/IntegrationTest.php';

final class Shinka_News_Test_Integration_ManagerTest extends Shinka_Core_Test_IntegrationTest
{
    protected $table = "news";
    protected $entity = Shinka_News_Entity_News;
    protected $values;
    protected $entities = array();

    protected function seed()
    {
        global $db;

        for ($ndx = 0; $ndx < 5; $ndx++) {
            $this->entities[] = $this->entity(array(
                "headline" => "Test Headline $ndx",
                'tags' => "tag_$ndx,$ndx_tag"
            ));
        }

        $this->entities = Shinka_News_Manager::create($this->entities);
    }

    protected function setUp()
    {
        parent::setUp();
        Shinka_News_Service_InstallService::handle();
        $this->values = array(
            'headline' => 'Test Headline',
            'text' => 'Test Text',
            'pinned' => true,
            'status' => Shinka_News_Constant_Status::APPROVED,
            'user' => array(
                'uid' => 123,
                'username' => 'Test Username'
            ),
            'thread' => array(
                'tid' => 345,
                'subject' => 'Test Subject'
            )
        ); 
        $this->seed();
    }

    protected function tearDown()
    {
        global $db;
        Shinka_News_Service_UninstallService::handle();
    }

    // public function testCreate()
    // {
    //     $originalCount = $this->countEntities();
    //     Shinka_News_Manager::create($this->entities[0]);
    //     $newCount = $this->countEntities();

    //     $expected = $originalCount + 1;
    //     $this->assertEquals($expected, $newCount);
    // }

    // public function testCreateArray()
    // {
    //     $originalCount = $this->countEntities();
    //     Shinka_News_Manager::create($this->entities);
    //     $newCount = $this->countEntities();

    //     $expected = $originalCount + count($this->entities);
    //     $this->assertEquals($expected, $newCount);
    // }

    // public function testDestroyEntity()
    // {
    //     $originalCount = $this->countEntities();
    //     Shinka_News_Manager::destroy($this->entities[0]);
    //     $newCount = $this->countEntities();

    //     $expected = $originalCount - 1;
    //     $this->assertEquals($expected, $newCount);
    // }

    // public function testDestroyEntities()
    // {
    //     $originalCount = $this->countEntities();
    //     Shinka_News_Manager::destroy($this->entities);
    //     $newCount = $this->countEntities();

    //     $expected = $originalCount - count($this->entities);
    //     $this->assertEquals($expected, $newCount);
    // }

    // public function testDestroyNID()
    // {
    //     $nid = $this->entities[0]->nid;

    //     $originalCount = $this->countEntities();
    //     Shinka_News_Manager::destroy($nid);
    //     $newCount = $this->countEntities();

    //     $expected = $originalCount - 1;
    //     $this->assertEquals($expected, $newCount);
    // }

    // public function testDestroyNIDs()
    // {
    //     $nids = array_map(function ($entity) {
    //         return $entity->nid;
    //     }, $this->entities);

    //     $originalCount = $this->countEntities();
    //     Shinka_News_Manager::destroy($nids);
    //     $newCount = $this->countEntities();

    //     $expected = $originalCount - count($nids);
    //     $this->assertEquals($expected, $newCount);
    // }

    public function testFindSimple()
    {
        $entity = $this->entities[0];
        $nid = $entity->nid;
        $news = Shinka_News_Manager::findSimple($nid);
        
        $this->assertInstanceOf(Shinka_News_Entity_News, $news);
        foreach ($this->values as $key => $value) {
            $this->assertEquals($entity->$key, $news->$key);
        }
    }

    public function testFind()
    {
        $nid = $this->entities[0]->nid;
        $news = Shinka_News_Manager::find($nid);
        
        $this->assertInstanceOf(Shinka_News_Entity_News, $news);
        $this->assertEquals($nid, $news->nid);
    }

    // public function testFindByTag()
    // {
    //     $tags = "{$this->entities[0]->tags}, {$this->entities[1]->tags}";
    //     $nid = $this->entities[0]->nid;
    //     $news = Shinka_News_Manager::find($nid);
        
    //     $this->assertInstanceOf(Shinka_News_Entity_News, $news);
    //     $this->assertEquals($nid, $news->nid);
    // }

    public function testAll()
    {
        $newses = Shinka_News_Manager::all();
        $this->assertEquals(count($this->entities), count($newses));
    }

    public function testCount()
    {
        $count = Shinka_News_Manager::count();
        $this->assertEquals(count($this->entities), $count);
    }
}
