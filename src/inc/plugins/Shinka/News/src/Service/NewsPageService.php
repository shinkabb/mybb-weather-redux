<?php

require_once MYBB_ROOT . "inc/functions.php";

class Shinka_News_Service_NewsPageService 
{
    public static function handle()
    {
        self::setup();

        $newses = Shinka_News_Manager::all();
        return Shinka_News_Presenter_NewsPagePresenter::present($newses);
    }
    
    protected static function setup()
    {
        global $lang, $templatelist;

        $templatelist .= "news_submit_important, news_submit, news_tag, news_delete, news_tag_filter";
    
        if (!$lang->news) {
            $lang->load('news');
        }
        
        add_breadcrumb($lang->news, "news.php");
    }
}