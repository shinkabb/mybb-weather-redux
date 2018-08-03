<?php

require_once getcwd() . '/inc/plugins/Shinka/News/Test/Integration/Presenter/PresenterTest.php';
require_once getcwd() . '/inc/plugins/Shinka/News/Test/Fixture/Fixture.php';

/**
 * @coversDefaultClass Shinka_News_Presenter_LatestNewsPresenter
 * @see     Shinka_News_Presenter_LatestNewsPresenterTest
 * @package Shinka\News\Test\Integration\Presenter
 */
final class Shinka_News_Test_Integration_Presenter_LatestNewsPresenterTest extends Shinka_News_Test_Integration_Presenter_PresenterTest
{
    protected static $template = "news_latest";

    /**
     * Creates and inserts news.
     */
    protected function seed()
    {
        global $db;

        for ($ndx = 0; $ndx < 5; $ndx++) {
            $this->entities[] = Shinka_News_Test_Fixture_Fixture::news(array(
                "headline" => "Test Headline $ndx",
                'tags' => "tag_$ndx,$ndx_tag"
            ));
        }

        $this->entities = Shinka_News_Manager::create($this->entities);
    }

    /**
     * Installs plugin, seeds news, and presents empty view.
     */
    protected function setUp()
    {
        parent::setUp();

        Shinka_News_Service_InstallService::handle();
        $this->seed();

        $this->presented = Shinka_News_Presenter_LatestNewsPresenter::present();
    }

    /**
     * Uninstalls plugin.
     */
    protected function tearDown()
    {
        Shinka_News_Service_UninstallService::handle();
    }

    /**
     * Sanity check for seed persistance
     * 
     * @test
     */
    public function testSeed()
    {
        $count = $this->countEntities("news");
        $this->assertEquals(count($this->entities), $count);
    }

    /**
     * Should present news_latest.
     * 
     * @test
     * @covers ::present
     */
    public function presentLatestNews()
    {
        $this->presented = Shinka_News_Presenter_LatestNewsPresenter::present($this->entities);
        $this->templateIsPresented(self::$template);
    }

    /**
     * Should present news_item for each entity.
     * 
     * @test
     * @covers ::present
     */
    public function presentNewsItems()
    {
        $this->presented = Shinka_News_Presenter_LatestNewsPresenter::present($this->entities);
        $this->templateIsPresented("news_item", count($this->entities));
    }

    /**
     * Should present news_no_news when given no entities.
     * 
     * @test
     * @covers ::present
     */
    public function presentNoNews()
    {
        $this->presented = Shinka_News_Presenter_LatestNewsPresenter::present();
        $this->templateIsPresented("news_no_news");
    }
}
