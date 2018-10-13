<?php

require_once getcwd() . '/inc/plugins/Shinka/Core/Test/IntegrationTest.php';
require_once getcwd() . '/inc/plugins/Shinka/News/Test/Fixture/Fixture.php';

/**
 * @coversDefaultClass Shinka_News_Service_SubmitNewsService
 * @see     Shinka_News_Service_SubmitNewsService
 * @package Shinka\News\Test\Integration\Service
 */
final class Shinka_News_Test_Integration_SubmitNewsServiceTest extends Shinka_Core_Test_IntegrationTest
{
    protected $entity = Shinka_News_Entity_News;
    protected $data;

    /**
     * Seeds user, thread, and news.
     */
    protected function seed()
    {
        global $db;

        $db->insert_query("users", Shinka_News_Test_Fixture_Fixture::user(array(
            'uid' => 1
        )));
        $db->insert_query("threads", Shinka_News_Test_Fixture_Fixture::thread(array(
            'tid' => 1
        )));

        for ($ndx = 0; $ndx < 5; $ndx++) {
            $this->entities[] = Shinka_News_Test_Fixture_Fixture::news(array(
                "headline" => "Test Headline $ndx",
                'tags' => "tag_$ndx,$ndx_tag"
            ));
        }

        $this->entities = Shinka_News_Manager::create($this->entities);
    }

    /**
     * Installs plugin and seeds database.
     */
    protected function setUp()
    {
        parent::setUp();
        Shinka_News_Service_InstallService::handle();
        $this->seed();
    }

    /**
     * Uninstalls plugin and truncates tables.
     */
    protected function tearDown()
    {
        global $db;
        Shinka_News_Service_UninstallService::handle();
        $db->delete_query("users", "");
        $db->delete_query("threads", "");
    }

    /**
     * Sanity check for seed persistence.
     * 
     * @test
     */
    public function testSeed()
    {
        $count = $this->countEntities("news");
        $this->assertEquals(count($this->entities), $count);

        $count = $this->countEntities("users");
        $this->assertEquals(1, $count);

        $count = $this->countEntities("threads");
        $this->assertEquals(1, $count);
    }

    /**
     * Should return a non-empty string.
     * 
     * @test
     * @covers ::handle
     */
    public function returnsEntity()
    {
        $entity = $this->entities[0]->toArray();
        $received = Shinka_News_Service_SubmitNewsService::handle($entity);
        $this->assertTrue(is_a($received, "Shinka_News_Entity_News"));
    }

    /**
     * Should persist entity.
     * 
     * @test
     * @covers ::handle
     */
    public function persistsEntity()
    {
        $count = $this->countEntities("news");
        $entity = $this->entities[0]->toArray();
        Shinka_News_Service_SubmitNewsService::handle($entity);
        $countAfter = $this->countEntities("news");

        $this->assertEquals($count + 1, $countAfter);
    }

    /**
     * Should return a non-empty string.
     * 
     * @test
     * @covers ::handle
     */
    public function returnsErrors()
    {
        $entity = $this->entities[0]->toArray();
        $entity['thread']['tid'] = 999;
        $received = Shinka_News_Service_SubmitNewsService::handle($entity);
        $expected = array("thread.tid" => array("exists"));
        $this->assertEquals($expected, $received);
    }
}
