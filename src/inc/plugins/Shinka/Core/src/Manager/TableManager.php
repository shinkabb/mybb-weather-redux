<?php

/**
 * Manages database tables.
 *
 * @see     Shinka_Core_Entity_Table
 * @package Shinka\Core\Manager
 */
class Shinka_Core_Manager_TableManager extends Shinka_Core_Manager_Manager
{
    /**
     * @param Shinka_Core_Entity_Table|Shinka_Core_Entity_Table[] $tables
     * @return int Exits with `-1` if any table already exists.
     */
    public static function create($tables)
    {
        global $db;

        foreach (self::toArray($tables) as $table) {
            if ($db->table_exists($table->name)) {
                return -1;
            }

            $definition_strs = implode(', ', $table->definitions);
            $db->write_query(
                'CREATE TABLE ' . TABLE_PREFIX . $table->name .
                "($definition_strs)"
            );
        }
    }

    /**
     * @param Shinka_Core_Entity_Table|Shinka_Core_Entity_Table[]|string|string[] $table Entity or table name
     */
    public static function drop($tables)
    {
        global $db;

        foreach (self::toArray($tables) as $table) {
            $name = $table instanceof Shinka_Core_Entity_Table ? $table->name : $table;
            $db->drop_table($name);
        }
    }
}
