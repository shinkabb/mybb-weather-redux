<?php

/**
 * Checks whether a user has permission to perform an action.
 *
 * @package Shinka\Core\Service
 */
class Shinka_Core_Service_PermissionService
{
    /**
     * Checks whether a user has a usergroup-based permission.
     * 
     * Consults usergroup permissions and optionally groupselect settings.
     * 
     * <code>
     * <?php
     * Shinka_Core_Service_PermissionService::can("a_setting");               // use current session
     * Shinka_Core_Service_PermissionService::can("a_setting", $user);        // fallback to settings
     * Shinka_Core_Service_PermissionService::can("a_setting", $user, false); // does not fallback
     * ?>
     * </code>
     * 
     * @param  string       $perm          Permission key
     * @param  integer|null $uid           User ID
     * @param  boolean      $checkSettings If no permission is found, look up
     *                                     setting with same key
     * @return boolean|integer -1 if invalid key
     */
    public static function can(string $perm, $user = null, $checkSettings = true)
    {
        global $mybb;

        $user = $user ?: $mybb->user;

        $perms = user_permissions($user['uid']);
        if (isset($perms[$perm])) {
            return !!$perms[$perm];
        }

        // Exit if invalid key and not falling back to settings
        if (!$checkSettings) {
            return -1;
        }

        $setting = $mybb->settings[$perm];
        return self::canSetting($setting, $user);
    }

    /**
     * Checks if user has permission from a groupselect setting.
     * 
     * <code>
     * <?php
     * Shinka_Core_Service_PermissionService::canSetting("a_setting");
     * Shinka_Core_Service_PermissionService::canSetting("a_setting", $user);
     * ?>
     * </code>
     *
     * @param  string|int $setting Setting value
     * @param  array      $user
     * @return boolean
     */
    public static function canSetting($setting, $user)
    {
        if (!isset($setting)) {
            return -1;
        }

        if ($setting === "-1") {
            return true;
        }
        
        if ($setting === "") {
            return false;
        }

        return self::hasGroup($setting, $user);
    }

    /**
     * Checks whether user belongs to at least one group in a list.
     * 
     * <code>
     * <?php
     * Shinka_Core_Service_PermissionService::hasGroup("1,2,3", $user);
     * Shinka_Core_Service_PermissionService::hasGroup(array(1, 2, 3), $user);
     * ?>
     * </code>
     *
     * @param  array|string $groups Comma-delimited string or array
     * @param  array        $user
     * @return boolean
     */
    public static function hasGroup($groups, $user)
    {
        // Strip out whitespace before exploding
        if (!is_array($groups)) {
            $groups = str_replace(" ", "", $group);
            $groups = explode(",", $groups);
        }

        $usergroups = explode(",", $user['additionalgroups']);
        $usergroups[] = $user['usergroup'];

        return !!array_intersect($groups, $usergroups);
    }
}
