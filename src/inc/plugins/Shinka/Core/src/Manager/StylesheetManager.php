<?php

class Shinka_Core_Manager_StylesheetManager extends Shinka_Core_Manager_Manager
{
    private static $table = "themestylesheets";

    /**
     * Create templates from files in the given directory
     *
     * @param Shinka_Core_Entity_Stylesheet|Shinka_Core_Entity_Stylesheet[] $stylesheets
     * @return void
     */
    public static function create($stylesheets)
    {
        require_once MYBB_ROOT . "admin/inc/functions_themes.php";
        global $db;

        foreach (self::toArray($stylesheets) as $stylesheet) {
            $sanitized = $stylesheet->toArray();
            $sanitized['stylesheet'] = $db->escape_string($sanitized['stylesheet']);
            $db->insert_query(self::$table, $sanitized);

            cache_stylesheet($stylesheet->tid, $stylesheet->name, $stylesheet->stylesheet);
            update_theme_stylesheet_list($stylesheet->tid);
        }
    }

    /**
     * @param Shinka_Core_Entity_Stylesheet|Shinka_Core_Entity_Stylesheet[] $stylesheets
     */
    public static function destroy($stylesheets)
    {
        require_once MYBB_ROOT . "admin/inc/functions_themes.php";
        global $db;

        foreach (self::toArray($stylesheets) as $stylesheet) {
            $tid = $stylesheet->tid;
            $name = $stylesheet->name;

            $db->delete_query(self::$table, "`name` = '$name'");

            $query = $db->simple_select("themes", "tid");
            while ($tid = $db->fetch_field($query, "tid")) {
                $file = MYBB_ROOT . "cache/themes/theme$tid/$name";
                if (file_exists($file)) {
                    unlink($file);
                }
            }

            update_theme_stylesheet_list('1');
        }
    }
}
