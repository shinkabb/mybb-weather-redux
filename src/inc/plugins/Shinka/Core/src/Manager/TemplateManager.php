<?php

class Shinka_Core_Manager_TemplateManager extends Shinka_Core_Manager_Manager
{
    private static $table = "templates";

    /**
     * Create templates from files in the given directory
     *
     * @param string  $asset_dir
     * @param string  $sid
     * @param string  $version
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
     * Delete templates with the given title prefix
     */
    public function destroy(string $prefix)
    {
        global $db;

        $db->delete_query(self::$table, "`title` LIKE '{$prefix}_%' OR `title` = '{$prefix}'");
    }
}
