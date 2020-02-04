<?php

class Shinka_Weather_Entity_Weather extends Shinka_Core_Entity_Entity
{
    public static function fromArray(array $arr)
    {
        $weather = $arr;
        $weather['temp']['metric'] = $weather['main']['temp'];
        $weather['temp']['imperial'] = ((float) $weather['weather']['temp'])*9/5+32;
        $weather['status'] = $weather['weather'][0]['main'];
        $weather['icon'] = strtolower($weather['weather'][0]['main']);
        $weather['iconCode'] = $weather['weather'][0]['icon'];

        return $weather;
    }
}
