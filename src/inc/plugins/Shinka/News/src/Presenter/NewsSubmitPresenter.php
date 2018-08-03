<?php

class Shinka_News_Presenter_NewsSubmitPresenter extends Shinka_News_Presenter_Presenter
{
    /**
     * @param Shinka_News_Entity_News|Shinka_News_Entity_News[]|array|array[] $newses
     */
    public static function present()
    {
        global $lang, $templates;

        if (!$lang->news) {
            $lang->load('news');
        }

        if (Shinka_Core_Entity_User::can("news_canpin")) {
            $pin = eval($templates->render('news_submit_pin'));
        }

        $tag_options = self::presentTags();

        return eval($templates->render('news_submit'));
    }

    private static function presentTags()
    {

        $tags = "one,two,three";
        $tags = explode(',', $tags);

        $tags = array_map(function ($tag) {
            return self::presentTag($tag);
        }, $tags);

        return implode($tags);
    }

    private static function presentTag($tag)
    {
        global $templates;
        $tag = array('key' => $tag, 'value' => $tag);
        return eval($templates->render('news_submit_tag'));
    }
}
