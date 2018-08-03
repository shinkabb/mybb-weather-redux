<?php

/**
 * @package Shinka\Core\Entity
 */
class Shinka_Core_Entity_Table extends Shinka_Core_Entity_Entity
{
    /** @var string Table name */
    public $name;

    /** @var array Table definitions */
    public $definitions;

    public function __construct(string $name, array $definitions)
    {
        $this->name = $name;
        $this->definitions = $definitions;
    }

    /**
     * Returns class properties as array.
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'name' => $this->name,
            'definitions' => $this->definitions,
        );
    }

    /**
     * Creates object from array.
     *
     * @param  array $data 
     * @return Shinka_Core_Entity_Table
     */
    public static function fromArray(array $data)
    {
        return new self(
            $data['name'],
            $data['definitions']
        );
    }
}
