<?php

class Shinka_Core_Entity_User extends Shinka_Core_Entity_Entity
{
    /** @var int  */
    public $uid;

    /** @var string */
    public $username;

    /**
     * Store name and table definitions
     */
    public function __construct(int $uid, string $username)
    {
        $this->uid = $uid;
        $this->username = $username;
    }

    public function toArray()
    {
        return array(
            'uid' => $this->uid,
            'username' => $this->username,
        );
    }

    public function fromArray(array $arr)
    {
        return new Shinka_Core_Entity_User(
            $arr['uid'],
            $arr['username']
        );
    }
}
