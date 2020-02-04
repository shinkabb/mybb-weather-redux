<?php

class Shinka_Weather_Service_InstallService
{
    public static function getSettingsGroup()
    {
        global $lang;

        $lang->load('weather');
        return array(
            "name" => "weathergroup",
            "title" => $lang->weather_settings_title,
            "description" => $lang->weather_settings_description,
            "disporder" => 5,
            "isdefault" => 0,
        );
    }

    public static function getSettings()
    {
        global $lang;

        if (!$lang->weather) {
            $lang->load('weather');
        }

        return array(
            "weather_api_key" => array(
                "title" => $lang->weather_api_key,
                "description" => $lang->weather_api_key_description,
                "optionscode" => "text",
                "value" => "",
                "disporder" => 1,
            ),
            "weather_zip" => array(
                "title" => $lang->weather_zip_code,
                "description" => $lang->weather_zip_code_description,
                "optionscode" => "text",
                "value" => "",
                "disporder" => 2,
            ),
            "weather_country" => array(
                "title" => $lang->weather_country,
                "description" => $lang->weather_country_description,
                "optionscode" => "text",
                "value" => "",
                "disporder" => 3,
            ),
        );
    }

    public static $template_group = array(
        'prefix' => 'weather',
        'title' => 'Weather',
        'isdefault' => 1,
        'asset_dir' => MYBB_ROOT . "inc/plugins/Shinka/Weather/resources/templates",
    );

    public static function handle()
    {
        require_once MYBB_ROOT . "inc/adminfunctions_templates.php";

        $setting_group = Shinka_Core_Entity_SettingGroup::fromArray(self::getSettingsGroup());

        $settings = self::getSettings();
        foreach ($settings as $key => &$setting) {
            $setting['name'] = $key;
            $setting = Shinka_Core_Entity_Setting::fromArray($setting);
        }


        $gid = Shinka_Core_Manager_SettingGroupManager::create($setting_group);
        Shinka_Core_Manager_SettingManager::create($settings, $gid);

        $template_groups = Shinka_Core_Entity_TemplateGroup::fromArray(self::$template_group);
        Shinka_Core_Manager_TemplateGroupManager::create($template_groups);

        find_replace_templatesets(
            "index",
            "#" . preg_quote('{$header}') . "#i",
            "{\$header}{\$weather_widget}"
        );

        rebuild_settings();
    }
}
