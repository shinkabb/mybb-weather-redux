<?php

require_once MYBB_ROOT . "inc/functions.php";

class Shinka_Weather_Service_WeatherService
{
    public static function handle()
    {
        global $weather_widget;

        self::setup();

        $weather = Shinka_Weather_Manager::get();
        $weather_widget = Shinka_Weather_Presenter_WeatherPresenter::present($weather);

        return $weather_widget;
    }
    
    protected static function setup()
    {
        global $lang, $templatelist;

        $templatelist .= "weather_widget";

        if (!$lang->weather) {
            $lang->load('weather');
        }
    }
}