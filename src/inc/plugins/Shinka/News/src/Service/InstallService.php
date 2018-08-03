<?php

class Shinka_News_Service_InstallService
{
    public static $tables = array(
        'news' => array(
            'nid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT',
            'tid INT(10) UNSIGNED',
            'uid INT(10) UNSIGNED NOT NULL',
            "headline VARCHAR(255) NOT NULL DEFAULT ''",
            "text VARCHAR(255) NOT NULL DEFAULT ''",
            "tags VARCHAR(255) NOT NULL DEFAULT ''",
            'pinned BOOL NOT NULL DEFAULT FALSE',
            "status VARCHAR(255) NOT NULL DEFAULT 'APPROVED'",
            'updated_at TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW()',
            'created_at TIMESTAMP NOT NULL DEFAULT NOW()',
            'PRIMARY KEY (nid)',
        ),
    );

    public static $settinggroup = array(
        "name" => "newsgroup",
        "title" => "News",
        "description" => "News description",
        "isdefault" => 0,
    );

    public static $settings = array(
        array(
            "name" => "news_perpage",
            "title" => '$lang->news_perpage',
            "description" => '$lang->news_perpage_description',
            "optionscode" => "numeric",
            "value" => 10,
        ),
        array(
            "name" => "news_onindex",
            "title" => '$lang->news_onindex',
            "description" => '$lang->news_onindex_description',
            "optionscode" => "numeric",
            "value" => 5,
        ),
        array(
            "name" => "news_requirethread",
            "title" => '$lang->news_requirethread',
            "description" => '$lang->news_requirethread_description',
            "optionscode" => "yesno",
            "value" => 1,
        ),
        array(
            "name" => "news_forums",
            "title" => '$lang->news_forums',
            "description" => '$lang->news_forums_description',
            "optionscode" => "forumselect",
            "value" => -1,
        ),
        array(
            "name" => "news_groups",
            "title" => '$lang->news_groups',
            "description" => '$lang->news_groups_description',
            "optionscode" => "groupselect",
            "value" => -1,
        ),
        array(
            "name" => "news_cansubmit",
            "title" => '$lang->news_cansubmit',
            "description" => '$lang->news_cansubmit_description',
            "optionscode" => "groupselect",
            "value" => -1,
        ),
        array(
            "name" => "news_canpin",
            "title" => '$lang->news_canpin',
            "description" => '$lang->news_canpin_description',
            "optionscode" => "groupselect",
            "value" => 4,
        ),
        array(
            "name" => "news_canedit",
            "title" => '$lang->news_canedit',
            "description" => '$lang->news_canedit_description',
            "optionscode" => "groupselect",
            "value" => 4,
        ),
        array(
            "name" => "news_caneditown",
            "title" => '$lang->news_caneditown',
            "description" => '$lang->news_caneditown_description',
            'optionscode' => 'yesno',
            "value" => 1,
        ),
        array(
            "name" => "news_candelete",
            "title" => '$lang->news_candelete',
            "description" => '$lang->news_candelete_description',
            "optionscode" => "groupselect",
            "value" => 4,
        ),
        array(
            "name" => "news_candeleteown",
            "title" => '$lang->news_candeleteown',
            "description" => '$lang->news_candeleteown_description',
            'optionscode' => 'yesno',
            "value" => 0,
        ),
        array(
            "name" => "news_tags",
            "title" => '$lang->news_tags',
            "description" => '$lang->news_tags_description',
            "optionscode" => "textarea",
            "value" => "personal=Personal\nsite_wide=Site Wide",
        ),
    );

    public static $template_group = array(
        'prefix' => 'news',
        'title' => 'News',
        'isdefault' => 1,
        'asset_dir' => MYBB_ROOT . "inc/plugins/Shinka/News/resources/templates",
    );

    public static function handle()
    {
        require_once MYBB_ROOT . "inc/adminfunctions_templates.php";

        $tables = new Shinka_Core_Entity_Table('news', self::$tables['news']);

        $setting_group = Shinka_Core_Entity_SettingGroup::fromArray(self::$settinggroup);

        $settings = self::$settings;
        foreach ($settings as $ndx => &$setting) {
            $setting['disporder'] = $ndx;
            $setting = Shinka_Core_Entity_Setting::fromArray($setting);
        }

        $template_groups = Shinka_Core_Entity_TemplateGroup::fromArray(self::$template_group);
        $stylesheets = Shinka_Core_Entity_Stylesheet::fromDirectory(MYBB_ROOT . "inc/plugins/Shinka/News/resources/themestylesheets");

        Shinka_Core_Manager_TableManager::create($tables);

        $gid = Shinka_Core_Manager_SettingGroupManager::create($setting_group);
        Shinka_Core_Manager_SettingManager::create($settings, $gid);

        Shinka_Core_Manager_TemplateGroupManager::create($template_groups);
        Shinka_Core_Manager_StylesheetManager::create($stylesheets);

        find_replace_templatesets(
            "index",
            "#" . preg_quote('{$header}') . "#i",
            "{\$header}{\$latest_news}"
        );

        rebuild_settings();
    }
}
