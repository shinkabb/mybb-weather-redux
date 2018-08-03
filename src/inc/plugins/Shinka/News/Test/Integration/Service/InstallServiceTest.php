<?php

use PHPUnit\Framework\TestCase;

require_once getcwd() . '/inc/plugins/Shinka/Core/Test/IntegrationTest.php';

/**
 * @coversDefaultClass Shinka_News_Service_InstallService
 * @see     Shinka_News_Service_InstallService
 * @package Shinka\News\Test\Integration\Service
 */
final class Shinka_News_Test_Integration_Service_InstallServiceTest extends Shinka_Core_Test_IntegrationTest
{
    /** @var string Absolute path to template resource directory */
    protected $template_dir;
    /** @var string Absolute path to stylesheet resource directory */
    protected $stylesheet_dir;

    /**
     * Sets resource paths and seeds templates.
     *
     * @return void
     */
    protected function setUp()
    {
        global $db;
        
        parent::setUp();
        $this->template_dir = getcwd() . "/inc/plugins/Shinka/News/resources/templates";
        $this->stylesheet_dir = getcwd() . "/inc/plugins/Shinka/News/resources/themestylesheets";
        
        $db->insert_query('templates', array(
            'title' => "index",
            'template' => $db->escape_string('{$header}'),
            'sid' => 1,
            'version' => '',
        ));
    }

    /**
     * Truncates tables.
     *
     * @return void
     */
    protected function tearDown()
    {
        global $db;

        $db->drop_table("news");
        $db->delete_query("settinggroups", "");
        $db->delete_query("settings", "");
        $db->delete_query("templategroups", "");
        $db->delete_query("templates", "");
        $db->delete_query("themestylesheets", "");
    }

    /**
     * Should create news table.
     * 
     * @test
     * @covers ::handle
     */
    public function createsTable()
    {
        global $db;

        Shinka_News_Service_InstallService::handle();

        $exists = $db->table_exists("news");
        $this->assertTrue($exists);
    }

    /**
     * Should insert setting group.
     * 
     * @test
     * @covers ::handle
     */
    public function createsSettingGroup()
    {
        global $db;

        $originalCount = $this->countEntities("settinggroups");
        Shinka_News_Service_InstallService::handle();
        $newCount = $this->countEntities("settinggroups");

        $expected = $originalCount + 1;
        $this->assertEquals($expected, $newCount);
    }

    /**
     * Should insert settings.
     * 
     * @test
     * @covers ::handle
     */
    public function createsSettings()
    {
        global $db;

        $originalCount = $this->countEntities("settings");
        Shinka_News_Service_InstallService::handle();
        $newCount = $this->countEntities("settings");

        $expected = $originalCount + count(Shinka_News_Service_InstallService::$settings);
        $this->assertEquals($expected, $newCount);
    }

    /**
     * Should insert template group.
     * 
     * @test
     * @covers ::handle
     */
    public function createsTemplateGroup()
    {
        global $db;

        $originalCount = $this->countEntities("templategroups");
        Shinka_News_Service_InstallService::handle();
        $newCount = $this->countEntities("templategroups");

        $expected = $originalCount + 1;
        $this->assertEquals($expected, $newCount);
    }

    /**
     * Should insert templates from resource directory.
     * 
     * @test
     * @covers ::handle
     */
    public function createsTemplates()
    {
        global $db;

        $originalCount = $this->countEntities("templates");
        Shinka_News_Service_InstallService::handle();
        $newCount = $this->countEntities("templates");

        $expected = $originalCount + $this->countFiles($this->template_dir);
        $this->assertEquals($expected, $newCount);
    }

    /**
     * Should insert stylesheets from resource directory.
     * 
     * @test
     * @covers ::handle
     */
    public function createsStylesheets()
    {
        global $db;

        $originalCount = $this->countEntities("themestylesheets");
        Shinka_News_Service_InstallService::handle();
        $newCount = $this->countEntities("themestylesheets");

        $expected = $originalCount + $this->countFiles($this->stylesheet_dir);
        $this->assertEquals($expected, $newCount);
    }
}

