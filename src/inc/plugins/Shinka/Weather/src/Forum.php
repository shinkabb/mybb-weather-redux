<?php

function weather_index()
{
    Shinka_Weather_Service_WeatherService::handle();
}

$plugins->add_hook("index_start", "weather_index");