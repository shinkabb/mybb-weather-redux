<?php

require_once getcwd() . '/inc/plugins/Shinka/Core/Test/IntegrationTest.php';
require_once getcwd() . '/inc/plugins/Shinka/News/Test/Fixture/Fixture.php';

final class Shinka_News_Test_Integration_ManagerTest extends Shinka_Core_Test_IntegrationTest
{
    protected $table = "news";
    protected $entity = Shinka_News_Entity_News;
    protected $entities = array();
    protected $values;

    protected function assertFind($a, $b)
    {
        $a = $a->toArray();
        $b = $b->toArray();

        unset($a['created_at']);

        foreach ($a as $key => $value) {
            $this->assertEquals($value, $b[$key]);
        }
    }

    protected function seed()
    {
        global $db;

        $db->insert_query("users", Shinka_News_Test_Fixture_Fixture::user($this->values['user']));
        $db->insert_query("threads", Shinka_News_Test_Fixture_Fixture::thread($this->values['thread']));

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
                'uid' => '1',
                'username' => 'Test Username'
            ),
            'thread' => array(
                'tid' => '1',
                'subject' => 'Test Subject'
            )
        ); 
        $this->seed();
    }

    protected function tearDown()
    {
        global $db;
        Shinka_News_Service_UninstallService::handle();
        $db->delete_query("users", "");
        $db->delete_query("threads", "");
    }

    public function testCreate()
    {
        $originalCount = $this->countEntities();
        Shinka_News_Manager::create($this->entities[0]);
        $newCount = $this->countEntities();

        $expected = $originalCount + 1;
        $this->assertEquals($expected, $newCount);
    }

    public function testCreateArray()
    {
        $originalCount = $this->countEntities();
        Shinka_News_Manager::create($this->entities);
        $newCount = $this->countEntities();

        $expected = $originalCount + count($this->entities);
        $this->assertEquals($expected, $newCount);
    }

    public function testDestroyEntity()
    {
        $originalCount = $this->countEntities();
        Shinka_News_Manager::destroy($this->entities[0]);
        $newCount = $this->countEntities();

        $expected = $originalCount - 1;
        $this->assertEquals($expected, $newCount);
    }

    public function testDestroyEntities()
    {
        $originalCount = $this->countEntities();
        Shinka_News_Manager::destroy($this->entities);
        $newCount = $this->countEntities();

        $expected = $originalCount - count($this->entities);
        $this->assertEquals($expected, $newCount);
    }

    public function testDestroyNID()
    {
        $nid = $this->entities[0]->nid;

        $originalCount = $this->countEntities();
        Shinka_News_Manager::destroy($nid);
        $newCount = $this->countEntities();

        $expected = $originalCount - 1;
        $this->assertEquals($expected, $newCount);
    }

    public function testDestroyNIDs()
    {
        $nids = array_map(function ($entity) {
            return $entity->nid;
        }, $this->entities);

        $originalCount = $this->countEntities();
        Shinka_News_Manager::destroy($nids);
        $newCount = $this->countEntities();

        $expected = $originalCount - count($nids);
        $this->assertEquals($expected, $newCount);
    }

    public function testFindSimple()
    {
        $entity = $this->entities[0];
        $nid = $entity->nid;
        $news = Shinka_News_Manager::findSimple($nid);

        unset($this->values['user']);
        unset($this->values['thread']);

        $this->assertInstanceOf(Shinka_News_Entity_News, $news);
        foreach ($this->values as $key => $value) {
            $this->assertEquals($entity->$key, $news->$key);
        }
    }

    public function testFind()
    {
        $entity = $this->entities[0];
        $news = Shinka_News_Manager::find($entity->nid);
        
        $this->assertInstanceOf(Shinka_News_Entity_News, $news);
        $this->assertNotNull($news->created_at);

        $this->assertFind($entity, $news);
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
        foreach ($this->entities as $ndx => $entity) {
            $this->assertFind($entity, $newses[$ndx]);
        }
    }

    public function testCount()
    {
        $count = Shinka_News_Manager::count();
        $this->assertEquals(count($this->entities), $count);
    }
}
