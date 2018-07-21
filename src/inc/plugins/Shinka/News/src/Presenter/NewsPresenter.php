<?php

class Shinka_News_Presenter_NewsPresenter extends Shinka_News_Presenter_Presenter
{
    public static $table = "news";
    public $manager;

    /**
     * @param Shinka_News_Entity_News|Shinka_News_Entity_News[]|array|array[] $newses
     */
    public static function present($newses)
    {
        global $templates;

        $presented = "";
        foreach (self::toArray($newses) as $news) {
            $news = $news instanceof Shinka_News_Entity_News ? $news : Shinka_News_Entity_News::fromArray($news);

            if ($thread = $news->thread) {
                $news_thread = eval($templates->render("news_thread"));
            }

            $presented .= eval($templates->render("news_item"));
        }

        return $presented;
    }
}
