<?php

class Shinka_News_Service_UninstallService
{
    public static $table = "news";
    public static $setting_group = "newsgroup";
    public static $prefix = "news";
    
    public static function handle()
    {
        require_once MYBB_ROOT . "inc/adminfunctions_templates.php";

        $stylesheets = Shinka_Core_Entity_Stylesheet::fromDirectory(MYBB_ROOT . "inc/plugins/Shinka/News/resources/themestylesheets");

        Shinka_Core_Manager_TableManager::drop(self::$table);
        $gid = Shinka_Core_Manager_SettingGroupManager::destroy(self::$setting_group);
        Shinka_Core_Manager_SettingManager::destroy(self::$prefix);
        Shinka_Core_Manager_TemplateGroupManager::destroy(self::$prefix);
        Shinka_Core_Manager_StylesheetManager::destroy($stylesheets);

        find_replace_templatesets(
            "index",
            "#" . preg_quote('{$latest_news}') . "#i",
            ""
        );

        rebuild_settings();
    }
}
