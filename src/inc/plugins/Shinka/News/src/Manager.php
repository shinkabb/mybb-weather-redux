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
        'news.status, news.created_at, user.username, user.usergroup, user.displaygroup, thread.subject ' .
        'FROM ' . TABLE_PREFIX . 'news news ' .
        'LEFT JOIN ' . TABLE_PREFIX . 'threads thread ON thread.tid = news.tid ' .
        'LEFT JOIN ' . TABLE_PREFIX . 'users user ON user.uid = news.uid ';

    /**
     * @param Shinka_News_Entity_News|Shinka_News_Entity_News[] $newses
     */
    public static function create($newses)
    {
        global $db;
        
        foreach (self::toArray($newses) as &$news) {
            $nid = $db->insert_query(self::$table, $news->forInsert());
            $news->nid = $nid;
        }

        return $newses;
    }

    /**
     * @param Shinka_News_Entity_News|Shinka_News_Entity_News[]|int|int[] $nids
     */
    public static function destroy($newses)
    {
        global $db;

        foreach (self::toArray($newses) as $news) {
            $nid = $news instanceof Shinka_News_Entity_News ? $news->nid : $news;
            $db->delete_query(self::$table, "nid = $nid", 1);
        }
    }

    public static function findSimple(int $nid, string $fields = "*")
    {
        global $db;

        $query = $db->simple_select(self::$table, $fields, "nid = $nid", array(
            "limit" => 1,
        ));
        return self::toObj($db->fetch_array($query));
    }

    public static function find(int $nid)
    {
        global $db;
        $query = self::$query . " WHERE news.nid = $nid" . 'LIMIT 1';
        $query = $db->write_query(self::$query);
        return self::toObj($db->fetch_array($query));
    }

    /**
     * @param string|string[] $tags
     */
    public static function findByTag($tags)
    {
        global $db;
        $query = self::$query . " WHERE news.nid = $nid";
        $query = $db->write_query($query);
        return self::toObj($db->fetch_array($query));
    }

    public static function all()
    {
        global $db;

        $query = $db->write_query(self::$query);
        while ($row = $db->fetch_array($query)) {
            $newses[] = self::toObj($row);
        }

        return $newses;
    }

    public static function count()
    {
        global $db;
        $query = $db->simple_select(self::$table, "COUNT(nid) as count", "", array());
        return $db->fetch_field($query, "count");
    }

    private static function toObj(array $arr)
    {
        $news = array(
            'nid' => $arr['nid'],
            'headline' => $arr['headline'],
            'text' => $arr['text'],
            'pinned' => !!$arr['pinned'],
            'status' => $arr['status'],
            'created_at' => $arr['created_at'],
            'thread' => $arr['tid'] ? array(
                'tid' => $arr['tid'],
                'subject' => $arr['subject']
            ) : array(),
            'user' => $arr['uid'] ? array(
                'uid' => $arr['uid'],
                'username' => $arr['username']
            ) : array()
        );

        return Shinka_News_Entity_News::fromArray($news);
    }
}
