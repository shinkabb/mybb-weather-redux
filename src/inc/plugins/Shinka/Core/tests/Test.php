<?php

use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    /**
     * @before
     */
    public function setupClassLoader()
    {
        defined("IN_MYBB") or define("IN_MYBB", true);
        defined("MYBB_ROOT") or define("MYBB_ROOT", getcwd() . '/');
        require_once MYBB_ROOT . "inc/plugins/news.php";
    }
}