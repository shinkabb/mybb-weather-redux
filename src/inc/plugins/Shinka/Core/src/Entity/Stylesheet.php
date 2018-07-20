<?php

class Shinka_Core_Entity_Stylesheet extends Shinka_Core_Entity_Entity
{
    public const DEFAULTS = array(
        'attachedto' => '',
        'tid' => 1
    );

    /** @var string  */
    public $stylesheet;

    /** @var string */
    public $name;

    /** @var int */
    public $attachedto;

    /** @var int */
    public $tid;

    /**
     * Store name and table definitions
     */
    public function __construct(string $stylesheet, string $name, 
        $attachedto = self::DEFAULTS['attachedto'], $tid = self::DEFAULTS['tid'])
    {
        $this->stylesheet = $stylesheet;
        $this->name = $name;
        $this->attachedto = $attachedto;
        $this->tid = $tid;

        $this->setDefaults(self::DEFAULTS);
    }

    public function toArray()
    {
        return array(
            'stylesheet' => $this->stylesheet,
            'name' => $this->name,
            'tid' => $this->tid,
            'attachedto' => $this->attachedto
        );
    }

    public static function fromDirectory(string $dir)
    {
        $files = array_slice(scandir($dir), 2);

        $stylesheets = array();
        foreach ($files as $file) {
            $css = file_get_contents($dir . '/' . $file, true);

            $stylesheets[] = new Shinka_Core_Entity_Stylesheet($css, $file);
        }

        return $stylesheets;
    }

    public static function fromArray(array $arr)
    {
        return new Shinka_Core_Entity_Stylesheet(
            $arr['stylesheet'],
            $arr['name'],
            $arr['attachedto'],
            $arr['tid']
        );
    }
}
