<?php

class Shinka_Core_Entity_SettingGroup extends Shinka_Core_Entity_Entity
{
    public const DEFAULTS = array(
        "disporder" => 5,
        "isdefault" => 0,
        "gid" => null
    );

    public $name;
    public $title;
    public $description;
    public $disporder;
    public $isdefault;
    public $gid;

    /**
     * Stores name and table definitions
     */
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

    public function toArray()
    {
        return array(
            'name' => $this->name,
            'title' => $this->title,
            'description' => $this->description,
            'disporder' => $this->disporder,
            'isdefault' => $this->isdefault,
            'gid' => $this->gid
        );
    }

    public static function fromArray(array $arr)
    {
        return new Shinka_Core_Entity_SettingGroup(
            $arr['name'], 
            $arr['title'], 
            $arr['description'], 
            $arr['disporder'], 
            $arr['isdefault'],
            $arr['gid']
        );
    }
}
