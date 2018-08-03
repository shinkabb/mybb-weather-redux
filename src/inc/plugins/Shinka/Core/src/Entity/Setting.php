<?php

/**
 * @package Shinka\Core\Entity
 * @see https://docs.mybb.com/1.8/development/plugins/basics/ For valid `optionscode` values
 */
class Shinka_Core_Entity_Setting extends Shinka_Core_Entity_Entity
{
    public const DEFAULTS = array(
        "disporder" => 1,
        "gid" => null
    );

    /** @var string Key name */
    public $name;

    /** @var string Display name */
    public $title;

    /** @var string */
    public $description;

    /** @var string Input type, e.g. `yesno` or `groupselect` */
    public $optionscode;

    /** @var string */
    public $value;

    /** @var int */
    public $disporder;

    /** @var int */
    public $gid;

    /**
     * <code>
     * <?php
     * $setting = new Shinka_Core_Entity_Setting("a_name", "A Title", "A description",
     *                                           "groupselect", "-1", 5, 1);
     * ?>
     * </code>
     */
    public function __construct(string $name, string $title, string $description, 
        string $optionscode, string $value, $disporder = self::DEFAULTS['disporder'], 
        $gid = self::DEFAULTS['gid'])
    {
        $this->name = $name;
        $this->title = $title;
        $this->description = $description;
        $this->optionscode = $optionscode;
        $this->value = $value;
        $this->disporder = $disporder;
        $this->gid = $gid;

        $this->setDefaults(self::DEFAULTS);
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
            'title' => $this->title,
            'description' => $this->description,
            'optionscode' => $this->optionscode,
            'value' => $this->value,
            'disporder' => $this->disporder,
            'gid' => $this->gid,
        );
    }

    /**
     * Creates object from array.
     * 
     * <code>
     * <?php
     * $data = array("name" => "a_name", "title" => "A Title", "description" => "A description", 
     *               "optionscode" => "groupselect");
     * $setting = Shinka_Core_Entity_Setting::fromArray($data);
     * ?>
     * </code>
     *
     * @param  array $data 
     * @return Shinka_Core_Entity_Setting
     */
    public static function fromArray(array $data)
    {
        return new self(
            $data['name'],
            $data['title'],
            $data['description'],
            $data['optionscode'],
            $data['value'],
            $data['disporder'],
            $data['gid']
        );
    }
}
