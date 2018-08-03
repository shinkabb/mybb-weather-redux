<?php

require_once MYBB_ROOT . "inc/functions.php";

class Shinka_News_Service_LatestNewsService 
{
    public static function handle()
    {
        global $latest_news;
        
        self::setup();

        $newses = Shinka_News_Manager::all(array("limit" => 5));
        $latest_news = Shinka_News_Presenter_LatestNewsPresenter::present($newses);

        return $latest_news;
    }
    
    protected static function setup()
    {
        global $lang, $templatelist;

        $templatelist .= "news_latest, news_item, news_pinned, news_pin, news_delete, news_no_news"; 
        $templatelist .= "news_thread, news_tag";
    
        if (!$lang->news) {
            $lang->load('news');
        }
    }
}