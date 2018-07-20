<?php

require_once getcwd() . '/inc/plugins/Shinka/Core/tests/IntegrationTest.php';
require_once getcwd() . '/inc/plugins/Shinka/Core/tests/Test.php';

final class DatabaseTest extends IntegrationTest
{
    protected function setUp()
    {
        global $db;
        parent::setUp();
    }

    public function testDatabaseConnection()
    {
        global $db;

        $this->assertNotNull($db);
        
        $query = $db->simple_select("users", "username", "", array());

        $this->assertNotNull($query);
    }
}
