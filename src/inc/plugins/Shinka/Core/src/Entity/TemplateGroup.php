<?php

class Shinka_Core_Entity_TemplateGroup extends Shinka_Core_Entity_Entity
{
    public const DEFAULTS = array(
        'isdefault' => 1
    );

    /** @var string Prefix templates should be grouped under */
    public $prefix;

    /** @var string */
    public $title;

    /** @var integer */
    public $isdefault = 1;

    /** @var string */
    public $asset_dir;

    /**
     * Store name and table definitions
     */
    public function __construct(string $asset_dir, string $prefix, string $title, 
        $isdefault = self::DEFAULTS['isdefault'])
    {
        $this->asset_dir = $asset_dir;
        $this->prefix = $prefix;
        $this->title = $title;
        $this->isdefault = $isdefault;

        $this->setDefaults(self::DEFAULTS);
    }

    public function toArray()
    {
        return array(
            'prefix' => $this->prefix,
            'title' => $this->title,
            'isdefault' => $this->isdefault,
        );
    }

    public static function fromArray($data)
    {
        return new Shinka_Core_Entity_TemplateGroup(
            $data['asset_dir'], 
            $data['prefix'], 
            $data['title'], 
            $data['isdefault']
        );
    }
}
