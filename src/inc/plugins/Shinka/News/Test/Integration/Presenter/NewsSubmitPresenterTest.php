<?php

use PHPUnit\Framework\TestCase;

require_once getcwd() . '/inc/plugins/Shinka/News/Test/Integration/Presenter/PresenterTest.php';
require_once getcwd() . '/inc/plugins/Shinka/News/Test/Fixture/Fixture.php';

/**
 * @coversDefaultClass Shinka_News_Presenter_NewsSubmitPresenter
 * @see     Shinka_News_Presenter_NewsSubmitPresenter
 * @package Shinka\News\Test\Integration\Presenter
 */
final class Shinka_News_Test_Integration_Presenter_NewsSubmitPresenterTest extends Shinka_News_Test_Integration_Presenter_PresenterTest
{
    protected static $template = "news_submit";

    /**
     * Presents basic view.
     */
    protected function present()
    {
        $this->presented = Shinka_News_Presenter_NewsSubmitPresenter::present();
    }

    /**
     * Installs plugin, seeds tags, and presents basic view.
     */
    protected function setUp()
    {
        parent::setUp();
        Shinka_News_Service_InstallService::handle();
        $this->tags = array("one", "two", "three");
        $this->present();
    }

    /**
     * Uninstalls plugin.
     */
    protected function tearDown()
    {
        Shinka_News_Service_UninstallService::handle();
    }

    /**
     * Should present news_submit template.
     * 
     * @test
     * @covers ::present
     */
    public function presentSubmit()
    {
        $this->templateIsPresented(self::$template);
    }

    /**
     * Should present news_submit_tag template for each tag.
     * 
     * @test
     * @covers ::present
     */
    public function presentTagOptions()
    {
        $this->templateIsPresented("news_submit_tag", count($this->tags));
    }


    /**
     * Should present news_submit_pin template when permitted.
     * 
     * @test
     * @covers ::present
     */
    public function presentPin()
    {
        $this->settings = array("news_canpin" => "-1");
        $this->seedSettings($this->settings);

        $this->presented = Shinka_News_Presenter_NewsSubmitPresenter::present();
        $this->templateIsPresented("news_submit_pin");
    }


    /**
     * Should not present news_submit_pin template not when permitted.
     * 
     * @test
     * @covers ::present
     */
    public function presentNoPin()
    {
        $this->settings = array("news_canpin" => "");
        $this->seedSettings();

        $this->presented = Shinka_News_Presenter_NewsSubmitPresenter::present();
        $this->templateIsNotPresented("news_submit_pin");
    }
}

