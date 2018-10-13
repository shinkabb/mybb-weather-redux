<?php

/**
 * Base class for entities.
 * 
 * @package Shinka\Core\Entity
 */
class Shinka_Core_Entity_Entity {
    public static $validate;
    public $errors = array();

    public function setDefaults(array $defaults)
    {
        foreach ($defaults as $key => $default)
        {
            $this->$key = isset($this->$key) ? $this->$key : $default;
        }
    }

    /**
     * Checks whether an entity's values
     * meet its validation requirements.
     * 
     * If <c>self::$validate</c> is a {@link \Shinka\Core\Validator\Shinka_Core_Validator}, 
     * run its <c>#validate</c> method.
     *
     * @return boolean
     */
    public function isValid()
    {
        $validate = $this::$validate;
        return ($validate === null || 
            (is_array($validate) && 
                Shinka_Core_Validator_RulesValidator::validate($this)) || 
            (is_a($validate, "Shinka_Core_Validator") && $validate->validate()));
    }
}