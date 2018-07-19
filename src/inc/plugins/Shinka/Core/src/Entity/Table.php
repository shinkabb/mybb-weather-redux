<?php
/**
 * Database table
 */
class Shinka_Core_Entity_Table extends Shinka_Core_Entity_Entity
{
    public $name;
    public $definitions;

    /**
     * Stores name and table definitions
     */
    public function __construct(string $name, array $definitions)
    {
        $this->name = $name;
        $this->definitions = $definitions;
    }

    public function toArray()
    {
        return array(
            'name' => $this->name,
            'definitions' => $this->definitions,
        );
    }

    public static function fromArray(array $arr)
    {
        return new Shinka_Core_Entity_Table(
            $arr['name'],
            $arr['definitions']
        );
    }
}
