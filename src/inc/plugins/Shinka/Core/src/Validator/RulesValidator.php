<?php

class Shinka_Core_Validator_RulesValidator extends Shinka_Core_Validator_Validator
{
    /**
     * Checks that entity meets its validation requirements.
     *
     * @param  Shinka_Core_Entity_Entity|array $entity
     * @param  array $rules Defaults to <c>$entity::$rules</c>
     * @return boolean
     */
    public static function validate($entity, $rules = null) {
        $rules = $rules === null ? $entity::$validate : $rules;

        if ($rules === null) {
            throw Exception("No validation rules found");
        }

        $errors = array();
        foreach ($rules as $property => $rulesStr) {
            $err = self::checkRule($property, self::getValue($entity, $property), $rulesStr);
            if ($err) {
                $errors[$property] = $err;
            }
        }

        $entity->errors = $errors;

        return !$errors;
    }

    /**
     * Checks that a value meets its validation requirements.
     * 
     * @param string $property - Property name
     * @param mixed  $value    - Property value
     * @param string $rulesStr - "|"-delimited string
     * @return array List of failed rules
     */
    public static function checkRule($property, $value, $rulesStr) {
        $rules = explode("|", $rulesStr);

        $errors = array();
        foreach ($rules as $str) {
            $rule = explode(":", $str);

            switch ($rule[0]) {
                case "required":
                    $valid = self::checkRequired($value);
                    break;
                case "exists":
                    $valid = self::checkExists($property, $value, $rule);
                    break;
            }

            if (!$valid) {
                $errors[] = $rule[0];
            }
        }

        return $errors;
    }

    public static function checkRequired($value) {
        return !($value === null || $value === "");
    }

    /**
     * Asserts that an entity with the given primary key
     * exists in the database.
     *
     * @param string $property - Table name fallback if not in $rule.
     * @param mixed  $value    - Property value
     * @param array  $rule     - In format <c>["exists", "table_name", "primary_key"]</c>
     * @return boolean
     */
    public static function checkExists(string $property, $value, array $rule) {   
        global $db;

        $lookup = self::shapeExistsRule($rule, $property);

        $query = $db->simple_select(
            $lookup["table"], "count(*) as count", "{$lookup['primaryKey']} = $value"
        );
        
        return $db->fetch_field($query, "count");
    }

    /**
     * Extracts table name and primary key from given information.
     * 
     * Table name defaults to <c>$property</c>.
     * Primary key defaults to <c>id</c>.
     *
     * @param  array  $rule     - In format <c>["exists", "table_name", "primary_key"]</c>
     * @param  string $property - Table name fallback if not in $rule.
     * @return array  In format <c>["table" => string, "primaryKey" => string]
     */
    public static function shapeExistsRule(array $rule, string $property = "") {
        // "tid" => "exists"
        // "tid" => "exists:thread",
        // "tid" => "exists:thread:tid"
        return array(
            "table" => isset($rule[1]) ? $rule[1] : $property,
            "primaryKey" => isset($rule[2]) ? $rule[2] : "id"
        );
    }

    /**
     * Drills down to fetch value via dot notation.
     *
     * e.g. <c>"obj.prop"</c> to fetch <c>$entity->obj->prop</c>.
     * 
     * @param  array  $entity
     * @param  string $property - Property name in dot notation
     * @return mixed
     */
    public static function getValue($entity, string $property) {
        $props = explode(".", $property);

        $value = $entity;
        foreach ($props as $prop) {
            $value = is_array($value) ? $value[$prop] : $value->$prop;
        }

        return $value;
    }
}
