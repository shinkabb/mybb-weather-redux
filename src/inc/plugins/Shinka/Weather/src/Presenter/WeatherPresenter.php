<?php

class Shinka_Weather_Presenter_WeatherPresenter
{
    /**
     * @param Shinka_Weather_Entity_Weather $weather
     * @return mixed
     */
    public static function present($weather)
    {
        global $lang, $templates;

        if (!$lang->weather) {
            $lang->load('weather');
        }

        $weather = Shinka_Weather_Entity_Weather::fromArray($weather);

        return eval($templates->render('weather_widget'));
    }
}
