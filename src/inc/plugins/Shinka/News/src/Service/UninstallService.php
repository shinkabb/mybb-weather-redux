<?php

class Shinka_News_Service_UninstallService
{
    public static function handle()
    {

        require_once MYBB_ROOT . "inc/adminfunctions_templates.php";

        $tables = "news";
        $setting_groups = "newsgroup";
        $prefix = "news";
        $stylesheets = Shinka_Core_Entity_Stylesheet::fromDirectory(MYBB_ROOT . "inc/plugins/Shinka/News/resources/themestylesheets");

        Shinka_Core_Manager_TableManager::drop($tables);
        $gid = Shinka_Core_Manager_SettingGroupManager::destroy($setting_groups);
        Shinka_Core_Manager_SettingManager::destroy($prefix);
        Shinka_Core_Manager_TemplateGroupManager::destroy($prefix);
        Shinka_Core_Manager_StylesheetManager::destroy($stylesheets);

        find_replace_templatesets(
            "index",
            "#" . preg_quote('{$latest_news}') . "#i",
            ""
        );

        rebuild_settings();
    }
}
