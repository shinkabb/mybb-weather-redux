<?php

/**
 * Manages database records for template groups.
 *
 * @see     Shinka_Core_Entity_TemplateGroup
 * @package Shinka\Core\Manager
 */
class Shinka_Core_Manager_TemplateGroupManager extends Shinka_Core_Manager_Manager
{
    private static $table = "templategroups";

    /**
     * @param Shinka_Core_Entity_TemplateGroup|Shinka_Core_Entity_TemplateGroup[] $groups
     * @return void
     */
    public static function create($groups)
    {
        global $db;

        foreach (self::toArray($groups) as $group) {
            $db->insert_query(self::$table, $group->toArray());

            if ($group->asset_dir) {
                Shinka_Core_Manager_TemplateManager::create($group->asset_dir);
            }
        }
    }

    /**
     * Deletes records by prefix.
     * 
     * @param string|string[]|Shinka_Core_Entity_TemplateGroup|Shinka_Core_Entity_TemplateGroup[] $prefixes Entity or prefix
     */
    public function destroy($groups)
    {
        global $db;

        foreach (self::toArray($groups) as $group) {
            $prefix = $group instanceof Shinka_Core_Entity_TemplateGroup ? $group->prefix : $group;
            $db->delete_query(self::$table, "`prefix` = '$prefix'");

            Shinka_Core_Manager_TemplateManager::destroy($prefix);
        }
    }
}
