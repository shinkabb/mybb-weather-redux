<?php
/**
 * Weather
 * Adds user-submitted weather feed.
 *
 * @package  Shinka\Weather
 * @category MyBB Plugins
 * @author   Kalyn Robinson <dev@shinkarpg.com>
 * @license  http://unlicense.org/ Unlicense
 * @version  1.0.0
 * @link     https://github.com/ShinkaBB/mybb-weather
 */

if (!defined('IN_MYBB')) {
    die('You Cannot Access This File Directly. Please Make Sure IN_MYBB Is Defined.');
}

if (defined('IN_ADMINCP')) {
    require_once MYBB_ROOT . 'inc/plugins/Shinka/Weather/src/Plugin.php';
} else {
    require_once MYBB_ROOT . 'inc/plugins/Shinka/Weather/src/Forum.php';
}

defined('MYBBSTUFF_CORE_PATH') or define('MYBBSTUFF_CORE_PATH', MYBB_ROOT . 'inc/plugins/MybbStuff/Core');
defined('SHINKA_CORE_PATH') or define('SHINKA_CORE_PATH', MYBB_ROOT . 'inc/plugins/Shinka/Core');
define('SHINKA_WEATHER_PATH', MYBB_ROOT . 'inc/plugins/Shinka/Weather');

require_once MYBBSTUFF_CORE_PATH . '/ClassLoader.php';

$classLoader = new MybbStuff_Core_ClassLoader();

$classLoader->registerNamespace(
    'Shinka_Weather',
    array(SHINKA_WEATHER_PATH . '/src')
);

$classLoader->registerNamespace(
    'Shinka_Core',
    array(SHINKA_CORE_PATH . '/src')
);

$classLoader->register();
