<?php

class Shinka_News_Presenter_LatestNewsPresenter extends Shinka_News_Presenter_Presenter
{
    public static $table = "news";
    public $manager;

    /**
     * @param Shinka_News_Entity_News|Shinka_News_Entity_News[]|array|array[] $newses
     */
    public static function present($newses = null)
    {
        global $lang, $templates;

        if (!$lang->news) {
            $lang->load('news');
        }

        $news = Shinka_News_Presenter_NewsPresenter::present($newses);
        return eval($templates->render('news_latest'));
    }
}
