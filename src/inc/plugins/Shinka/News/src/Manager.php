<?php

/**
 * Manages objects in database
 *
 * @package Shinka\News
 */
class Shinka_News_Manager extends Shinka_Core_Manager_Manager
{
    /** @var string */
    private static $table = "news";

    /** @var string Base query for news */
    private static $query = 'SELECT news.nid, news.headline, news.text, news.tid, news.uid, news.tags, news.pinned, ' .
        'news.status, user.uid, user.username, user.usergroup, user.displaygroup, thread.subject ' .
        'FROM ' . TABLE_PREFIX . 'news news ' .
        'LEFT JOIN ' . TABLE_PREFIX . 'threads thread ON thread.tid = news.tid ' .
        'INNER JOIN ' . TABLE_PREFIX . 'users user ON user.uid = news.uid ';

    /**
     * @return
     */
    public static function create(Shinka_News_Entity_News $newses)
    {
        global $db;
        foreach (self::toArray($newses) as $news) {
            $db->insert_query(self::$table, $news->toArray());
        }
    }

    public static function destroy(array $nids)
    {
        global $db;
        foreach (self::toArray($nids) as $nid) {
            $db->delete_query("nid = $nid", 1);
        }
    }

    public static function destroyItems(array $news)
    {
        global $db;
        foreach ($news as $n) {
            $this->destroyItem($n);
        }
    }

    public static function findSimple(integer $nid, string $fields = "*")
    {
        global $db;
        return $db->simple_select($fields, "nid = $nid", array(
            "limit" => 1,
        ));
    }

    public static function find(integer $nid)
    {
        global $db;
        $query = self::$query . " WHERE news.nid = $nid";
        return $db->write_query(self::$query);
    }

    /**
     * @param string|string[] $tags
     */
    public static function findByTag($tags, string $fields = "*")
    {
        global $db;
        $query = self::$query . " WHERE news.nid = $nid";
        return $db->write_query(self::$query);
    }

    public static function all()
    {
        global $db;
        return $db->write_query(self::$query);
    }

    public static function count()
    {
        global $db;
        return $db->simple_select("COUNT(news.nid)", array());
    }
}
