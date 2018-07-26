<?php

use PHPUnit\Framework\TestCase;

class Shinka_Core_Test_Test extends TestCase
{
    /**
     * Run class loader
     */
    protected function setUp()
    {
        defined("IN_MYBB") or define("IN_MYBB", true);
        defined("MYBB_ROOT") or define("MYBB_ROOT", getcwd() . '/');
        require_once MYBB_ROOT . "inc/plugins/news.php";
    }

    protected function entity(array $values = array())
    {
        return $this->entity::fromArray(
            array_merge($this->values, $values)
        );
    }
}