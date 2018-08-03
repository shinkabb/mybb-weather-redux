<?php

/**
 * Responsible for common plugin functions
 *
 * Should not be invoked manually.
 *
 * @package  Shinka\News
 */
function news_info()
{
    global $lang;

    if (!$lang->news) {
        $lang->load('news');
    }

    return array(
        'name' => $lang->news,
        'description' => $lang->news_description,
        'website' => 'https://github.com/ShinkaDev-MyBB/News',
        'author' => 'Shinka',
        'authorsite' => 'https://github.com/ShinkaDev-MyBB',
        "codename" => "news",
        'version' => '1.0.0',
        'compatibility' => '18*',
    );
}

/**
 * @return void
 */
function news_install()
{
    Shinka_News_Service_InstallService::handle();
}

/**
 * @return boolean
 */
function news_is_installed()
{
    global $db;

    return $db->table_exists('news');
}

/**
 * @return void
 */
function news_uninstall()
{
    Shinka_News_Service_UninstallService::handle();
}

function news_activate()
{}

function news_deactivate()
{}