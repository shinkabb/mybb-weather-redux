<?php

/**
 * Manages database records for setting groups.
 *
 * @see     Shinka_Core_Entity_SettingGroup
 * @package Shinka\Core\Manager
 */
class Shinka_Core_Manager_SettingGroupManager extends Shinka_Core_Manager_Manager
{
    /** @var string */
    private static $table = "settinggroups";

    /**
     * @param  Shinka_Core_Entity_SettingGroup $group
     * @return int GID of created setting group
     */
    public static function create(Shinka_Core_Entity_SettingGroup $group)
    {
        global $db;
        
        return $db->insert_query(self::$table, $group->toArray());
    }

    /**
     * Deletes records by setting group name.
     * 
     * @param string|string[]|Shinka_Core_Entity_SettingGroup|Shinka_Core_Entity_SettingGroup[] $groups Entity or group name
     */
    public static function destroy($groups)
    {
        global $db;

        foreach (self::toArray($groups) as $group) {
            $name = $group instanceof Shinka_Core_Entity_SettingGroup ? $group->name : $group;
            $db->delete_query(self::$table, "`name` = '$name'");
        }
    }
}
