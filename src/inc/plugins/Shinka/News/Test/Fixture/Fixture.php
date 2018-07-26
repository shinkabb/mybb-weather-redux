<?php

class Shinka_News_Test_Fixture_Fixture {
    public static $defaults = array(
        'user' => array(
            'signature' => 'signature',
            'buddylist' => '',
            'ignorelist' => '',
            'pmfolders' => '',
            'notepad' => '',
            'usernotes' => ''
        ),
        'thread' => array(
            'notes' => ''
        ),
        'news' => array(
            'headline' => 'Test Headline',
            'text' => 'Test Text',
            'pinned' => true,
            'status' => Shinka_News_Constant_Status::APPROVED,
            'user' => array(
                'uid' => '1',
                'username' => 'Test Username'
            ),
            'thread' => array(
                'tid' => '1',
                'subject' => 'Test Subject'
            )
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
        return array_merge(self::$defaults['news'], $values);
    }
}