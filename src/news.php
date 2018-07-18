<?php

define("IN_MYBB", 1);
define('THIS_SCRIPT', 'news.php');

require_once "./global.php";

$templatelist = "news, news_important, news_item, news_latest, news_mark_as, news_no_news, ";
$templatelist .= "news_submit_important, news_submit, news_tag, news_delete, news_tag_filter";

global $mybb, $lang, $templates, $plugins, $db;

if (!$lang->news) {
    $lang->load('news');
}

add_breadcrumb($lang->news, "news.php");

$plugins->run_hooks("shinka_news_start");

$query = Shinka_News_Manager::all();
$newses = array();
while ($news = $db->fetch_array($query)) {
    $newses[] = Shinka_News_Entity_News::fromArray($news);
}

var_dump($newses);

Shinka_News_Manager::create(
    Shinka_News_Entity_News::fromArray(array(
        'tid' => 1,
        'uid' => 1,
        'headline' => 'A Headline',
        'text' => 'A text',
    )));

$news = Shinka_News_Presenter_News::present(
    $newses
);

$page = eval($templates->render('news'));
output_page($page);
