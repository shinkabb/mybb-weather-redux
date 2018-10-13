<?php

require_once MYBB_ROOT . "inc/functions.php";

class Shinka_News_Presenter_NewsPresenter extends Shinka_News_Presenter_Presenter
{
    public static $table = "news";
    public $manager;

    /**
     * Builds templates for given news
     *
     * If no news given, presents news_no_news template.
     *
     * @param Shinka_News_Entity_News|Shinka_News_Entity_News[]|array|array[] $newses
     */
    public static function present($newses = null)
    {
        global $lang, $templates;

        if (!$lang->news) {
            $lang->load('news');
        }

        if (!$newses) {
            return eval($templates->render("news_no_news"));
        }

        return self::presentItems($newses);
    }

    private static function presentItems($newses)
    {
        $presented = array_map(function ($news) {
            return self::presentItem($news);
        }, self::toArray($newses));

        return implode($presented);
    }

    private static function presentItem($news)
    {
        global $templates, $mybb;

        $news = $news instanceof Shinka_News_Entity_News ? $news : Shinka_News_Entity_News::fromArray($news);

        if (Shinka_Core_Entity_User::can("news_candelete")) {
            $delete = eval($templates->render("news_delete"));
        }

        if (Shinka_Core_Entity_User::can("news_canpin")) {
            $pin = eval($templates->render("news_pin"));
        }

        if ($news->pinned) {
            $pinned = eval($templates->render("news_pinned"));
        }

        if ($thread = $news->thread) {
            $news_thread = eval($templates->render("news_thread"));
        }

        $news->created_at = my_date($mybb->settings['dateformat'], strtotime("YYYY-MM-DD HH:mm:ss", $news->created_at));

        return eval($templates->render("news_item"));
    }
}
