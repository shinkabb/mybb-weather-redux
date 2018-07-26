<?php

use PHPUnit\Framework\TestCase;

require_once getcwd() . '/inc/plugins/Shinka/Core/Test/IntegrationTest.php';

final class Shinka_News_Test_Unit_Presenter_NewsPresenterTest extends Shinka_Core_Test_IntegrationTest
{
    protected $entity = Shinka_News_Entity_News;
    protected $entities;
    protected $values;

    private function createEntities()
    {
        for ($ndx = 0; $ndx < 5; $ndx++) {
            $this->entities[] = $this->entity(array(
                'headline' => "Test Headline $ndx",
                'username' => "Test Username $ndx"
            ));
        }
    }

    private function present()
    {
        $this->presented = Shinka_News_Presenter_NewsPresenter::present($this->entities[0]);
    }

    private function isPresented($value, $presented = null)
    {

        $exists = strpos($presented ?: $this->presented, $value) >= 0;
        $this->assertTrue($exists);
    }

    private function isNotPresented($value, $presented = null)
    {

        $exists = strpos($presented ?: $this->presented, $value);

        $this->assertFalse($exists);
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
        $this->createEntities();
        $this->present();
    }

    protected function tearDown()
    {
        Shinka_News_Service_UninstallService::handle();
    }

    public function testPresentsSomething()
    {
        $this->assertGreaterThan(0, strlen($this->presented));
    }

    public function testPresentsArray()
    {
        $this->presented = Shinka_News_Presenter_NewsPresenter::present($this->entities);
        foreach ($this->entities as $entity) {
            $this->isPresented($entity->headline);
        }
    }

    public function testPresentsHeadline()
    {
        $entity = $this->entities[0];
        $this->isPresented($entity->headline);
    }

    public function testPresentsPinned()
    {
        $entity = $this->entities[0];
        $this->isPresented("pinned-$entity->pinned");
    }

    public function testPresentsStatus()
    {

        $entity = $this->entities[0];
        $this->isPresented("status-$entity->status");
    }

    public function testPresentsUserID()
    {
        $entity = $this->entities[0];
        $this->isPresented($entity->user['uid']);
    }

    public function testPresentsUsername()
    {
        $entity = $this->entities[0];
        $this->isPresented($entity->user['username']);
    }

    public function testPresentsThreadID()
    {
        $entity = $this->entities[0];
        $this->isPresented($entity->thread['tid']);
    }

    public function testPresentsThreadSubject()
    {
        $entity = $this->entities[0];
        $this->isPresented($entity->thread['subject']);
    }

    public function testPresentsNoThread()
    {
        $entity = $this->entities[0];
        $entity->thread = array();
        $this->presented = Shinka_News_Presenter_NewsPresenter::present($entity);
        $this->isNotPresented("tid=");
    }
}

