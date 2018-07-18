<?php

class Shinka_News_Entity_News
{
    /** @var string  Terse subject */
    public $headline;

    /** @var string  Body text */
    public $text;

    /** @var integer Author ID */
    public $uid;

    /** @var integer Associated thread ID */
    public $tid;

    /** @var boolean Whether news should be pinned */
    public $pinned;

    /** @var string  Moderation status */
    public $status;

    public function __construct(string $headline, string $text, int $uid, $tid = null,
        $pinned = false, $status = Shinka_News_Constant_Status::APPROVED) {
        $this->headline = $headline;
        $this->text = $text;
        $this->uid = $uid;
        $this->tid = $tid;
        $this->pinned = $pinned;
        $this->status = $status;
        $this->user = $user;
    }

    public function toArray()
    {
        return array(
            'headline' => $this->headline,
            'text' => $this->text,
            'uid' => $this->uid,
            'tid' => $this->tid,
            'pinned' => $this->pinned,
            'status' => $this->status,
        );
    }

    public static function fromArray(array $arr)
    {
        return new Shinka_News_Entity_News(
            $arr['headline'],
            $arr['text'],
            $arr['uid'],
            $arr['tid'],
            $arr['pinned'],
            $arr['status']
        );
    }

    public static function forInsert(array $arr)
    {
        return array(
            'headline' => $this->headline,
            'text' => $this->text,
            'uid' => $this->uid,
            'tid' => $this->tid,
            'pinned' => $this->pinned,
            'status' => $this->status,
        );
    }
}
