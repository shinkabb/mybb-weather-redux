<?php

require_once getcwd() . '/inc/plugins/Shinka/Core/Test/IntegrationTest.php';
require_once getcwd() . '/inc/plugins/Shinka/Core/Test/Test.php';

/**
 * @package Shinka\Core\Test\Integration
 */
final class Shinka_Core_Test_Integration_DatabaseTest extends Shinka_Core_Test_IntegrationTest
{
    protected function setUp()
    {
        global $db;
        parent::setUp();
    }

    /**
     * Sanity checks $db global and database connection.
     *
     * @test
     */
    public function testDatabaseConnection()
    {
        global $db;

        $this->assertNotNull($db);
        
        $query = $db->simple_select("users", "username", "", array());

        $this->assertNotNull($query);
    }
}
