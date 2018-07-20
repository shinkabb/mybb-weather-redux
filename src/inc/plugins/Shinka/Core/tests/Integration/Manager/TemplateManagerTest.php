<?php

require_once getcwd() . '/inc/plugins/Shinka/Core/tests/IntegrationTest.php';

final class Shinka_Core_Test_Integration_Manager_TemplateManagerTest extends Shinka_Core_Test_IntegrationTest
{
    protected $table = "templates";
    protected $entity = Shinka_Core_Entity_Template;
    protected $asset_dir;
    protected $prefixes;

    protected function setUp()
    {
        parent::setUp();
        $this->asset_dir = getcwd() . '/inc/plugins/Shinka/Core/tests/data/templates';
        $this->prefixes = array("prefix");
    }

    protected function tearDown()
    {
        global $db;
        $db->delete_query($this->table, "");
    }

    public function testCreate()
    {
        $originalCount = $this->countEntities();
        Shinka_Core_Manager_TemplateManager::create($this->asset_dir);
        $newCount = $this->countEntities();

        $expected = $originalCount + $this->countFiles($this->asset_dir);
        $this->assertEquals($expected, $newCount);
    }

    public function testDestroy()
    {
        Shinka_Core_Manager_TemplateManager::create($this->asset_dir);

        $originalCount = $this->countEntities();
        Shinka_Core_Manager_TemplateManager::destroy($this->prefixes[0]);
        $newCount = $this->countEntities();

        $expected = $originalCount - $this->countFiles($this->asset_dir);
        $this->assertEquals($expected, $newCount);
    }
}
