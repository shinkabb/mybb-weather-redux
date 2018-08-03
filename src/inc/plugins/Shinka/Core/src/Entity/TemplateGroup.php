<?php

/**
 * @package Shinka\Core\Entity
 */
class Shinka_Core_Entity_TemplateGroup extends Shinka_Core_Entity_Entity
{
    public const DEFAULTS = array(
        'isdefault' => 1
    );

    /** @var string Prefix templates should be grouped under */
    public $prefix;

    /** @var string Display name */
    public $title;

    /** @var int 1 if core template group, 0 if from plugin */
    public $isdefault = 1;

    /** @var string Directory with associated templates */
    public $asset_dir;

    public function __construct(string $asset_dir, string $prefix, string $title, 
        $isdefault = self::DEFAULTS['isdefault'])
    {
        $this->asset_dir = $asset_dir;
        $this->prefix = $prefix;
        $this->title = $title;
        $this->isdefault = $isdefault;

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
            'prefix' => $this->prefix,
            'title' => $this->title,
            'isdefault' => $this->isdefault,
        );
    }

    /**
     * Creates object from array.
     *
     * @param  array $data 
     * @return Shinka_Core_Entity_TemplateGroup
     */
    public static function fromArray($data)
    {
        return new self(
            $data['asset_dir'], 
            $data['prefix'], 
            $data['title'], 
            $data['isdefault']
        );
    }
}
