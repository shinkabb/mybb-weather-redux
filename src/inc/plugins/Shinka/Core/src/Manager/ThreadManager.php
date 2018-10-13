<?php

/**
 * Manages database records for threads.
 *
 * @see     Shinka_Core_Entity_Thread
 * @package Shinka\Core\Manager
 */
class Shinka_Core_Manager_ThreadManager extends Shinka_Core_Manager_Manager
{
    private static $table = "threads";

    /**
     * @param  Shinka_Core_Entity_Thread|Shinka_Core_Entity_Thread[] $threads
     * @return void
     */
    public static function create($threads)
    {
        global $db;

        $tids = array();
        foreach (self::toArray($threads) as $ndx => $thread) {
            $tids[] = $db->insert_query(self::$table, $thread->toArray());
        }
    }

    /**
     * Deletes records by thread ID.
     * 
     * @param string|string[] $prefixes
     */
    public static function destroy($tids)
    {
        global $db;

        foreach (self::toArray($tids) as $ndx => $tid) {
            $db->delete_query(self::$table, "`tid` = {$tid}");
        }
    }

    public static function find(int $tid, string $fields = "*")
    {
        global $db;

        $query = $db->simple_select(self::$table, $fields, "tid = $tid", array(
            "limit" => 1,
        ));
        return $db->fetch_array($query);
    }

    public static function first(string $fields = "*")
    {
        global $db;

        $query = $db->simple_select(self::$table, $fields, "", array(
            "limit" => 1,
        ));
        return $db->fetch_array($query);
    }

    public static function all(string $fields = "*")
    {
        global $db;

        $query = $db->simple_select(self::$table, $fields, "", array());
        $threads = array();
        while ($thread = $db->fetch_array($query)) {
            $threads[] = $thread;
        }

        return $threads;
    }
}
