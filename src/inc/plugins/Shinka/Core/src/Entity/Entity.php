<?php

class Shinka_Core_Entity_Entity {
    public function setDefaults(array $defaults)
    {
        foreach ($defaults as $key => $default)
        {
            $this->$key = isset($this->$key) ? $this->$key : $default;
        }
    }
}