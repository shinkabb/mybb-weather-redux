<?php

require_once getcwd() . '/inc/plugins/Shinka/Core/tests/Test.php';
require_once getcwd() . '/inc/functions.php';
require_once getcwd() . '/inc/db_base.php';
require_once getcwd() . '/inc/db_mysqli.php';

class Shinka_Core_Test_IntegrationTest extends Shinka_Core_Test_Test
{
    protected function entity(array $values = array())
    {
        return $this->entity::fromArray(
            array_merge($this->values, $values)
        );
    }

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
        global $mybb;
        require_once MYBB_ROOT."inc/class_core.php";
        
		$mybb = new MyBB;
    }

    protected static function setupCache()
    {
        global $cache;
        require_once MYBB_ROOT.'inc/class_datacache.php';

        $cache = new datacache;
    }

    protected static function setupDatabase()
    {
        require getcwd() . '/inc/plugins/Shinka/Core/tests/data/config/database.php';
        global $db;

        $db = new DB_MySQLi;
        define("TABLE_PREFIX", $config['database']['table_prefix']);
        $db->connect($config['database']);
        $db->set_table_prefix(TABLE_PREFIX);
        $db->type = $config['database']['type'];
    }

    protected function setUp()
    {
        self::setupMyBB();
        self::setupDatabase();
        self::setupCache();
    }
}
