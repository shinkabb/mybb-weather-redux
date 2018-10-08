<?php

class Shinka_News_Entity_News extends Shinka_Core_Entity_Entity
{
    public const DEFAULTS = array(
        'nid' => null,
        'pinned' => false,
        'status' => Shinka_News_Constant_Status::APPROVED,
        'user' => array(),
        'thread' => array() 
    );

    /** @var int ID */
    public $nid;

    /** @var string Terse subject */
    public $headline;

    /** @var string Body text */
    public $text;

    /** @var boolean Whether news should be pinned */
    public $pinned;

    /** @var string Unix timestamp */
    public $created_at;

    /** @var array Author */
    public $user;

    /** 
     * @var string  Moderation status
     * @see Shinka_News_Constant_Status
     */
    public $status;

    /** @var array */
    public $thread;

    public function __construct(string $headline, string $text, $pinned = false, $status = Shinka_News_Constant_Status::APPROVED, $created_at = null, $user = array(), $thread = array(), $nid = null) {
        $this->headline = $headline;
        $this->text = $text;
        $this->pinned = $pinned;
        $this->status = $status;
        $this->created_at = $created_at;
        $this->user = $user;
        $this->thread = $thread;
        $this->nid = $nid;

        $this->setDefaults(self::DEFAULTS);
    }

    public function toArray()
    {
        return array(
            'nid' => $this->nid,
            'headline' => $this->headline,
            'text' => $this->text,
            'pinned' => $this->pinned,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'user' => $this->user,            
            'thread' => $this->thread,
        );
    }

    public function forInsert()
    {
        return array(
            'headline' => $this->headline,
            'text' => $this->text,
            'pinned' => $this->pinned,
            'status' => $this->status,
            'uid' => $this->user['uid'],            
            'tid' => $this->thread['tid'],
        );
    }

    public static function fromArray(array $arr)
    {
        return new Shinka_News_Entity_News(
            $arr['headline'],
            $arr['text'],
            $arr['pinned'],
            $arr['status'],
            $arr['created_at'],            
            $arr['user'],
            $arr['thread'],
            $arr['nid']
        );
    }
}
