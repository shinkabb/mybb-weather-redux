<?php

require_once getcwd() . '/inc/plugins/Shinka/News/Test/Integration/Presenter/PresenterTest.php';
require_once getcwd() . '/inc/plugins/Shinka/News/Test/Fixture/Fixture.php';

/**
 * @coversDefaultClass Shinka_News_Presenter_NewsPagePresenter
 * @see     Shinka_News_Presenter_NewsPagePresenter
 * @package Shinka\News\Test\Integration\Presenter
 */
final class Shinka_News_Test_Integration_Presenter_NewsPagePresenterTest extends Shinka_News_Test_Integration_Presenter_PresenterTest
{
    protected static $template = "news";

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

        $this->presented = Shinka_News_Presenter_NewsPagePresenter::present();
    }

    /**
     * Uninstalls plugin.
     */
    protected function tearDown()
    {
        Shinka_News_Service_UninstallService::handle();
    }

    /**
     * Sanity check for seed persistance.
     * 
     * @test
     */
    public function testSeed()
    {
        $count = $this->countEntities("news");
        $this->assertEquals(count($this->entities), $count);
    }

    /**
     * Should present news_page template.
     * 
     * @test
     * @covers ::present
     */
    public function presentPage()
    {
        $this->templateIsPresented(self::$template, count($this->entities), $presented);
    }

    /**
     * Should present news_item template for each entity.
     * 
     * @test
     * @covers ::present
     */
    public function presentNewsItems()
    {
        $presented = Shinka_News_Presenter_NewsPagePresenter::present($this->entities);
        $this->templateIsPresented("news_item", count($this->entities), $presented);
        $this->templateIsNotPresented("news_no_news", $presented);
    }

    /**
     * Should present news_no_news template for empty list.
     * 
     * @test
     * @covers ::present
     */
    public function presentNoNews()
    {
        $this->templateIsNotPresented("news_item");
        $this->templateIsPresented("news_no_news", 1);
    }

    /**
     * Should present news_submit template with permission.
     * 
     * @test
     * @covers ::present
     */
    public function presentSubmit()
    {
        $this->templateIsPresented("news_submit", 1);
    }

    /**
     * Should not present news_submit template without permission.
     * 
     * @test
     * @covers ::present
     */
    public function testPresentsNoSubmit()
    {
        $this->settings = array(
            "news_cansubmit" => ""
        );
        $this->seedSettings();

        $presented = Shinka_News_Presenter_NewsPagePresenter::present();

        $this->templateIsNotPresented("news_submit", $presented);
    }
}
