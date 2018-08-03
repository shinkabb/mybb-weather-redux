<?php

use PHPUnit\Framework\TestCase;

require_once getcwd() . '/inc/plugins/Shinka/Core/Test/IntegrationTest.php';
require_once getcwd() . '/inc/plugins/Shinka/News/Test/Fixture/Fixture.php';

/**
 * Provides helper functions for presenter tests.
 * 
 * @package Shinka\News\Test\Integration\Presenter
 */
class Shinka_News_Test_Integration_Presenter_PresenterTest extends Shinka_Core_Test_IntegrationTest
{
    protected static $template;
    protected $entities;
    protected $settings;

    /**
     * Asserts that a substring exists in a string.
     *
     * @param  string $substr    Substring to locate
     * @param  string $presented Defaults to class member `presented` 
     * @return boolean
     */
    protected function isPresented(string $substr, $presented = null)
    {
        $exists = strpos($presented ?: $this->presented, $substr) !== false;
        $this->assertTrue($exists);
    }

    /**
     * Asserts that a substring does not exist in a string.
     *
     * @param  string $substr    Substring to locate
     * @param  string $presented Defaults to class member `presented` 
     * @return boolean
     */
    protected function isNotPresented(string $substr, $presented = null)
    {
        $exists = strpos($presented ?: $this->presented, $substr) !== false;
        $this->assertFalse($exists);
    }

    /**
     * Asserts that a template is presented.
     *
     * Checks for the HTML attribute `data-template` with the given template as its value.
     *
     * @param  string $template  Substring to locate
     * @param  int    $times     Expected number of occurrences 
     * @param  string $presented Defaults to class member `presented` 
     * @return boolean
     */
    protected function templateIsPresented(string $template, int $times = 1, $presented = null)
    {
        $count = substr_count($presented ?: $this->presented, "data-template=\"{$template}\"");
        $this->assertEquals($times, $count);
    }

    /**
     * Asserts that a template is not presented.
     *
     * Checks for the HTML attribute `data-template` with the given template as its value.
     *
     * @param  string $substr    Substring to locate
     * @param  string $presented Defaults to class member `presented` 
     * @return boolean
     */
    protected function templateIsNotPresented(string $template, $presented = null)
    {
        $count = substr_count($presented ?: $this->presented, "data-template=\"{$template}\"");
        $this->assertEquals(0, $count);
    }
}

