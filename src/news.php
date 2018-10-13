<?php

define("IN_MYBB", 1);
define('THIS_SCRIPT', 'news.php');

require_once getcwd() . '/global.php';

handleRequest();
// $page = Shinka_News_Service_NewsPageService::handle();

// output_page($page);

function handleRequest() {
    global $mybb;

    if ($mybb->request_method == "post") {
        Shinka_News_Service_SubmitNewsService::handle();
    }
}