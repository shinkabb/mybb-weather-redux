<?php

class Shinka_Core_Manager_SettingGroupManager extends Shinka_Core_Manager_Manager
{
    private static $table = "settinggroups";

    /**
     * @param Shinka_Core_Entity_SettingGroup $setting_group
     * @return int GID of created setting group
     */
    public static function create(Shinka_Core_Entity_SettingGroup $setting_group)
    {
        global $db;
        
        return $db->insert_query(self::$table, $setting_group->toArray());
    }

    /**
     * @param string|string[]|Shinka_Core_Entity_SettingGroup|Shinka_Core_Entity_SettingGroup[] $setting_groups
     */
    public function destroy($setting_groups)
    {
        global $db;

        foreach (self::toArray($setting_groups) as $group) {
            $name = $group instanceof Shinka_Core_Entity_SettingGroup ? $group->name : $group;
            $db->delete_query(self::$table, "`name` = '$name'");
        }
    }
}
