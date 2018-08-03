<?php

/**
 * @package Shinka\Core\Entity
 */
class Shinka_Core_Entity_SettingGroup extends Shinka_Core_Entity_Entity
{
    public const DEFAULTS = array(
        "disporder" => 5,
        "isdefault" => 0,
        "gid" => null
    );

    /** @var int */
    public $gid;

    /** @var string Key name */
    public $name;

    /** @var string Display name */
    public $title;

    /** @var string */
    public $description;

    /** @var int Display order */
    public $disporder;

    /** @var boolean True if core setting, false if plugin setting */
    public $isdefault;

    public function __construct(string $name, string $title, string $description, 
        $disporder = self::DEFAULTS['disporder'], $isdefault = self::DEFAULTS['isdefault'], 
        $gid = self::DEFAULTS['gid'])
    {
        $this->name = $name;
        $this->title = $title;
        $this->description = $description;
        $this->disporder = $disporder;
        $this->isdefault = $isdefault;
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
            'disporder' => $this->disporder,
            'isdefault' => $this->isdefault
        );
    }

    /**
     * Creates object from array.
     *
     * @return Shinka_Core_Entity_SettingGroup
     */
    public static function fromArray(array $arr)
    {
        return new self(
            $arr['name'], 
            $arr['title'], 
            $arr['description'], 
            $arr['disporder'], 
            $arr['isdefault'],
            $arr['gid']
        );
    }
}
