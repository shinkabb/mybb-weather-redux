<?php

/**
 * Manages database records for templates.
 *
 * @see     Shinka_Core_Entity_Template
 * @package Shinka\Core\Manager
 */
class Shinka_Core_Manager_TemplateManager extends Shinka_Core_Manager_Manager
{
    private static $table = "templates";

    /**
     * Creates templates from files in a directory.
     *
     * @param  string $asset_dir Path to directory
     * @param  string $sid       Template set ID
     * @param  string $version   MyBB version
     * @return void
     */
    public static function create(string $asset_dir = '', string $sid = '-2', string $version = '')
    {
        global $db;

        // Slice out '.' and '..'
        $files = array_slice(scandir($asset_dir), 2);

        foreach ($files as $file) {
            $template = file_get_contents($asset_dir . '/' . $file, true);
            // trim off .html from file name
            $name = substr($file, 0, -5);

            $db->insert_query('templates', array(
                'title' => $db->escape_string($name),
                'template' => $db->escape_string($template),
                'sid' => $sid,
                'version' => $version,
                'dateline' => time(),
            ));
        }
    }

    /**
     * Deletes records by title prefix.
     * 
     * e.g. the prefix "shinka" would delete "shinka" and shinka_one".
     * 
     * @param string $prefix Title prefix
     */
    public function destroy(string $prefix)
    {
        global $db;

        $db->delete_query(self::$table, "`title` LIKE '{$prefix}_%' OR `title` = '{$prefix}'");
    }
}
