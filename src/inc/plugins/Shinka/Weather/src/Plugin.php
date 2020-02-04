<?php

/**
 * Responsible for common plugin functions
 *
 * Should not be invoked manually.
 *
 * @package  Shinka\Weather
 */
function weather_info()
{
    global $lang;

    if (!$lang->weather) {
        $lang->load('weather');
    }

    return array(
        'name' => $lang->weather,
        'description' => $lang->weather_description,
        'website' => 'https://github.com/ShinkaBB/Weather',
        'author' => 'Shinka',
        'authorsite' => 'https://github.com/ShinkaBB',
        'codename' => 'weather',
        'version' => '2.0.0',
        'compatibility' => '18*',
    );
}

/**
 * @return void
 */
function weather_install()
{
    Shinka_Weather_Service_InstallService::handle();
}

/**
 * @return boolean
 */
function weather_is_installed()
{
    global $mybb;

    return isset($mybb->settings["weather_zip"]);
}

/**
 * @return void
 */
function weather_uninstall()
{
    Shinka_Weather_Service_UninstallService::handle();
}

function weather_activate()
{}

function weather_deactivate()
{}

