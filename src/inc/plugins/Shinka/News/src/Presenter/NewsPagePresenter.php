<?php

class Shinka_News_Presenter_NewsPagePresenter extends Shinka_News_Presenter_Presenter
{
    public static $table = "news";
    public $manager;

    /**
     * @param Shinka_News_Entity_News|Shinka_News_Entity_News[]|array|array[] $newses
     */
    public static function present($newses = null)
    {
        global $lang, $templates, $headerinclude, $header, $errors, $multipage, $footer;

        if (!$lang->news) {
            $lang->load('news');
        }

        $news = Shinka_News_Presenter_NewsPresenter::present($newses);
        if (Shinka_Core_Entity_User::can("news_cansubmit")) {
            $news_submit = eval($templates->render('news_submit'));
        }

        return eval($templates->render('news'));
    }
}
