<?php

class Shinka_News_Presenter_News extends Shinka_News_Presenter_Presenter
{
    public static $table = "";
    public $manager;

    public static function present($newses)
    {
        global $templates;

        $html = "";
        foreach (self::toArray($newses) as $news) {
            $html .= eval($templates->render("news_item"));
        }

        return $html;
    }
}
