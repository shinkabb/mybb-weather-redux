<?php

class Shinka_News_Presenter_Presenter
{
    public static function toArray($obj)
    {
        return is_array($obj) ? $obj : array($obj);
    }
}
