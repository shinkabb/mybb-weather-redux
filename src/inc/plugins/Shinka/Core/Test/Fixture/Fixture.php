<?php

/**
 * Provides data for common entities.
 * 
 * @package Shinka\Core\Test\Fixture
 */
class Shinka_Core_Test_Fixture_Fixture {
    public static $defaults = array(
        'user' => array(
            'username' => 'Test Username',
            'signature' => 'signature',
            'buddylist' => '',
            'ignorelist' => '',
            'pmfolders' => '',
            'notepad' => '',
            'usernotes' => ''
        ),
        'thread' => array(
            'subject' => 'Test Subject',
            'notes' => ''
        ),
        'usergroup' => array(
            'title' => 'Test Usergroup',
            'description' => 'test description',
            'disporder' => 5
        )
    );

    public static function user($values = array())
    {
        return array_merge(self::$defaults['user'], $values);
    }

    public static function thread($values = array())
    {
        return array_merge(self::$defaults['thread'], $values);
    }

    public static function news($values = array())
    {
        return Shinka_News_Entity_News::fromArray(
            array_merge(self::$defaults['news'], $values)
        );
    }

    public static function usergroup($values = array())
    {
        return array_merge(self::$defaults['usergroup'], $values);
    }
}