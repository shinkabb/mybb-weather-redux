<?php

use PHPUnit\Framework\TestCase;

require_once getcwd() . '/inc/plugins/Shinka/News/Test/Integration/Presenter/PresenterTest.php';
require_once getcwd() . '/inc/plugins/Shinka/News/Test/Fixture/Fixture.php';

/**
 * @coversDefaultClass Shinka_News_Presenter_NewsPresenter
 * @see     Shinka_News_Presenter_NewsPresenter
 * @package Shinka\News\Test\Integration\Presenter
 */
final class Shinka_News_Test_Integration_Presenter_NewsPresenterTest extends Shinka_News_Test_Integration_Presenter_PresenterTest
{
    protected static $template = "news_item";
    protected $entities;
    protected $values;

    /**
     * Creates news from fixtures.
     */
    private function createEntities()
    {
        for ($ndx = 0; $ndx < 5; $ndx++) {
            $this->entities[] = Shinka_News_Test_Fixture_Fixture::news($this->values);
        }
    }

    /**
     * Presents basic view.
     */
    protected function present()
    {
        $this->presented = Shinka_News_Presenter_NewsPresenter::present($this->entities[0]);
    }

    /**
     * Installs plugin, seed news, and present basic view.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->values = array(
            'pinned' => true,
            'created_at' => 678,
            'user' => array(
                'uid' => 123,
                'username' => 'Test Username'
            ),
            'thread' => array(
                'tid' => 345,
                'subject' => 'Test Subject'
            )
        );   
        
        Shinka_News_Service_InstallService::handle();
        $this->createEntities();
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
     * Should present news_item template from News entity.
     * 
     * @test
     * @covers ::present
     */
    public function presentSomething()
    {
        $this->templateIsPresented(self::$template);
    }

    /**
     * Should present from given array.
     * 
     * @test
     * @covers ::present
     */
    public function presentSomethingFromArray()
    {
        $this->presented = Shinka_News_Presenter_NewsPresenter::present($this->entities);
        $this->templateIsPresented(self::$template, count($this->entities));
    }

    /**
     * Should include item's headline.
     * 
     * @test
     * @covers ::present
     */
    public function presentHeadline()
    {
        $entity = $this->entities[0];
        $this->isPresented($entity->headline);
    }

    /**
     * Should include item's pinned state.
     * 
     * @test
     * @covers ::present
     */
    public function presentPinnedClass()
    {
        $entity = $this->entities[0];
        $this->isPresented("pinned-$entity->pinned");
    }

    /**
     * Should include item's moderation status.
     * 
     * @test
     * @covers ::present
     */
    public function presentStatusClass()
    {

        $entity = $this->entities[0];
        $this->isPresented("status-$entity->status");
    }

    /**
     * Should include item's user ID.
     * 
     * @test
     * @covers ::present
     */
    public function presentUserID()
    {
        $user = $this->entities[0]->user;
        $this->isPresented("uid={$user['uid']}");
    }

    /**
     * Should include item's username.
     * 
     * @test
     * @covers ::present
     */
    public function presentUsername()
    {
        $entity = $this->entities[0];
        $this->isPresented($entity->user['username']);
    }

    /**
     * Should present news_thread when item has an associated thread.
     * 
     * @test
     * @covers ::present
     */
    public function presentThread()
    {
        $this->templateIsPresented('news_thread');
    }

    /**
     * Should include item's thread ID.
     * 
     * @test
     * @covers ::present
     */
    public function presentThreadID()
    {
        $thread = $this->entities[0]->thread;
        $this->isPresented("tid={$thread['tid']}");
    }

    /**
     * Should include item's thread subject.
     * 
     * @test
     * @covers ::present
     */
    public function presentThreadSubject()
    {
        $thread = $this->entities[0]->thread;
        $this->isPresented($thread['subject']);
    }

    /**
     * Should not present news_thread when news has no associated thread.
     * 
     * @test
     * @covers ::present
     */
    public function presentNoThread()
    {
        $entity = $this->entities[0];
        $entity->thread = array();
        $this->presented = Shinka_News_Presenter_NewsPresenter::present($entity);
        $this->templateIsNotPresented("news_thread");
    }

    /**
     * Should present news_pinned when item is pinned.
     * 
     * @test
     * @covers ::present
     */
    public function presentPinned()
    {
        $this->templateIsPresented("news_pinned");
    }

    /**
     * Should not present news_pinned when item is not pinned.
     * 
     * @test
     * @covers ::present
     */
    public function presentNotPinned()
    {
        $entity = $this->entities[0];
        $entity->pinned = false;
        $this->presented = Shinka_News_Presenter_NewsPresenter::present($entity);
        $this->templateIsNotPresented("news_pinned");
    }

    /**
     * Should present news_pin when permitted.
     * 
     * @test
     * @covers ::present
     */
    public function presentPin()
    {
        $this->settings = array(
            "news_canpin" => "-1"
        );
        $this->seedSettings();

        $entity = $this->entities[0];
        $this->presented = Shinka_News_Presenter_NewsPresenter::present($entity);

        $this->templateIsPresented("news_pin");
    }

    /**
     * Should not present news_pin when not permitted.
     * 
     * @test
     * @covers ::present
     */
    public function presentNotPin()
    {
        $this->settings = array(
            "news_canpin" => ""
        );
        $this->seedSettings();

        $this->templateIsNotPresented("news_pin");
    }

    /**
     * Should present news_delete when permitted.
     * 
     * @test
     * @covers ::present
     */
    public function presentDelete()
    {
        global $mybb;
        $this->settings = array(
            "news_candelete" => "-1"
        );
        $this->seedSettings();

        $entity = $this->entities[0];
        $this->presented = Shinka_News_Presenter_NewsPresenter::present($entity);

        $this->templateIsPresented("news_delete");
    }

    /**
     * Should not present news_delete when not permitted.
     * 
     * @test
     * @covers ::present
     */
    public function presentNotDelete()
    {
        $this->settings = array(
            "news_candelete" => ""
        );
        $this->seedSettings();

        $this->templateIsNotPresented("news_delete");
    }

    /**
     * Should present news_no_news when given no news.
     * 
     * @test
     * @covers ::present
     */
    public function presentNoNews()
    {
        $this->presented = Shinka_News_Presenter_NewsPresenter::present(null);

        $this->templateIsPresented("news_no_news");
    }
}

