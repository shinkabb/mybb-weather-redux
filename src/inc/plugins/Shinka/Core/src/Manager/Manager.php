<?php

/**
 * Base class for data managers.
 * 
 * Handles inserting, retrieving, and deleting database records.
 * 
 * @package Shinka\Core\Manager
 */
class Shinka_Core_Manager_Manager
{
    /**
     * Wraps object in array if non-array.
     *
     * @param  $obj 
     * @return array
     */
    public static function toArray($obj)
    {
        return is_array($obj) ? $obj : array($obj);
    }
}
