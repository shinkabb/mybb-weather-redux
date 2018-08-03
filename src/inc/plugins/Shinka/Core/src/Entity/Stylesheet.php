<?php

/**
 * @package Shinka\Core\Entity
 */
class Shinka_Core_Entity_Stylesheet extends Shinka_Core_Entity_Entity
{
    public const DEFAULTS = array(
        'attachedto' => '',
        'tid' => 1
    );

    /** @var int */
    public $tid;

    /** @var string CSS content */
    public $stylesheet;

    /** @var string Should end in .css */
    public $name;

    /** @var string Pages stylesheet is used on */
    public $attachedto;

    public function __construct(string $stylesheet, string $name, 
        $attachedto = self::DEFAULTS['attachedto'], $tid = self::DEFAULTS['tid'])
    {
        $this->stylesheet = $stylesheet;
        $this->name = $name;
        $this->attachedto = $attachedto;
        $this->tid = $tid;

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
            'stylesheet' => $this->stylesheet,
            'name' => $this->name,
            'tid' => $this->tid,
            'attachedto' => $this->attachedto
        );
    }

    /**
     * Creates objects from files in directory.
     *
     * @param  string $dir Path to directory
     * @return Shinka_Core_Entity_Stylesheet
     */
    public static function fromDirectory(string $dir)
    {
        $files = array_slice(scandir($dir), 2);

        $stylesheets = array();
        foreach ($files as $file) {
            $css = file_get_contents($dir . '/' . $file, true);

            $stylesheets[] = new self($css, $file);
        }

        return $stylesheets;
    }

    /**
     * Creates object from array.
     *
     * @param  array $data
     * @return Shinka_Core_Entity_Stylesheet
     */
    public static function fromArray(array $data)
    {
        return new self(
            $data['stylesheet'],
            $data['name'],
            $data['attachedto'],
            $data['tid']
        );
    }
}
