<?php

class Shinka_Weather_Service_UninstallService
{
    public static $setting_group = "weathergroup";
    public static $prefix = "weather";
    
    public static function handle()
    {
        require_once MYBB_ROOT . "inc/adminfunctions_templates.php";

        $gid = Shinka_Core_Manager_SettingGroupManager::destroy(self::$setting_group);
        Shinka_Core_Manager_SettingManager::destroy(self::$prefix);
        Shinka_Core_Manager_TemplateGroupManager::destroy(self::$prefix);

        find_replace_templatesets(
            "index",
            "#" . preg_quote('{$weather_widget}') . "#i",
            ""
        );

        rebuild_settings();
    }
}
