<?php

require_once getcwd() . '/inc/plugins/Shinka/Core/Test/Test.php';
require_once getcwd() . '/inc/functions.php';
require_once getcwd() . '/inc/db_base.php';
require_once getcwd() . '/inc/db_mysqli.php';

/**
 * Sets up MyBB globals and database connection.
 * 
 * @package Shinka\Core\Test
 */
class Shinka_Core_Test_IntegrationTest extends Shinka_Core_Test_Test
{

    protected function countFiles(string $dir)
    {
        // subtract 2 to account for '.' and '..'
        return count(scandir($dir)) - 2;
    }

    protected function countEntities($table = null)
    {
        global $db;

        $query = $db->simple_select($table ?: $this->table, "COUNT(*) as count", "", array());
        return (int) $db->fetch_field($query, "count");
    }

    protected static function setupMyBB()
    {
        global $mybb, $grouppermignore, $groupzerogreater;
        require_once MYBB_ROOT."inc/class_core.php";
        
        $mybb = new MyBB;
    }

    protected static function setupCache()
    {
        require_once MYBB_ROOT.'inc/class_datacache.php';
        global $cache;

        $cache = new datacache;
    }

    protected static function setupTemplates()
    {
        require_once MYBB_ROOT.'inc/class_templates.php';
        global $templates;

        $templates = new templates;
    }

    protected static function setupDatabase()
    {
        require MYBB_ROOT.'/inc/plugins/Shinka/Core/Test/resources/config/database.php';
        global $db;

        $db = new DB_MySQLi;
        define("TABLE_PREFIX", $config['database']['table_prefix']);
        $db->connect($config['database']);
        $db->set_table_prefix(TABLE_PREFIX);
        $db->type = $config['database']['type'];
    }

    protected static function setupLang()
    {
        require_once MYBB_ROOT."inc/class_language.php";
        global $lang;
        
        $lang = new MyLanguage;
        $lang->set_path(MYBB_ROOT."inc/languages");
    }

    protected static function setupPlugins()
    {
        require_once MYBB_ROOT."inc/class_plugins.php";
        global $plugins;
        
        $plugins = new pluginSystem;
    }

    protected static function setupTimer()
    {
        global $maintimer;

        require_once MYBB_ROOT."inc/class_timers.php";
        $maintimer = new timer();
    }

    /**
     * Overrides MyBB settings.
     *
     * @param array $settings
     */
    protected function seedSettings($settings = array())
    {
        global $mybb;

        $mybb->settings = $settings;
    }

    protected function setUp()
    {
        parent::setUp();

        defined("TIME_NOW") or define("TIME_NOW", time());
        self::setupMyBB();
        self::setupDatabase();
        self::setupCache();
        self::setupTemplates();
        self::setupLang();
        self::setupPlugins();
        self::setupTimer();
    }
}
