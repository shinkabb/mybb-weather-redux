<?php

class Shinka_Core_Manager_Manager
{
    public static function toArray($obj)
    {
        return is_array($obj) ? $obj : array($obj);
    }
}
