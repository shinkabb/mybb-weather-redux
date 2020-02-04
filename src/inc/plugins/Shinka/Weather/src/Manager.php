<?php

/**
 * Manages objects in database
 *
 * @package Shinka\Weather
 */
class Shinka_Weather_Manager extends Shinka_Core_Manager_Manager
{

    static function get() {
        $api_key = self::getSettingValue('api_key');
        $zip = self::getSettingValue('zip');
        $country = self::getSettingValue('country');

        if (!($api_key && $zip && $country)) {
            return false;
        }

        if (!self::checkCache($zip, $country, $api_key)) {
            return self::getCached();
        }

        $url = self::buildUrl($zip, $country, $api_key);
        $weather = self::sendRequest($url);
        self::updateCache($weather, $zip, $country, $api_key);

        return $weather;
    }

    protected static function buildUrl($zip, $country, $api_key)
    {
        return "http://api.openweathermap.org/data/2.5/weather?zip={$zip},{$country}&units=metric&APPID={$api_key}";
    }

    protected static function sendRequest($url)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }

    protected static function getSettingValue($name)
    {
        global $mybb;
        return $mybb->settings['weather_' . $name];
    }

    protected static function updateCache($response, $zip, $country, $api_key)
    {
        global $cache;

        $weather = $cache->read('weather');
        $weather = !$weather ? array() : $weather;
        $weather['settings'] = array(
            'api_key' => $api_key,
            'zip' => $zip,
            'country' => $country,
        );
        $weather['response'] = $response;
        $weather['time'] = time();
        $cache->update('weather', $weather);
    }

    /**
     * @return boolean `true` if cache should be invalidated
     */
    protected static function checkCache($zip, $country, $api_key)
    {
        global $cache;

        $weather = $cache->read('weather');

        if (!$weather) {
            return true;
        }

        $ONE_HOUR = 3600;
        return (
            (!isset($weather['time']) || $weather['time'] < time() - $ONE_HOUR) ||
            $weather['settings']['api_key'] != $api_key ||
            $weather['settings']['zip'] != $zip ||
            $weather['settings']['country'] != $country
        );
    }

    protected static function getCached()
    {
        global $cache;
        $weather = $cache->read('weather');
        return $weather['response'];
    }
}
