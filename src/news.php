<?php

define("IN_MYBB", 1);
define('THIS_SCRIPT', 'news.php');

require_once __DIR__ . '/global.php';

$page = Shinka_News_Service_NewsPageService::handle();

output_page($page);
