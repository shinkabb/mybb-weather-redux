<?php

class Shinka_Core_Entity_User extends Shinka_Core_Entity_Entity
{
    /** @var int  */
    public $uid;

    /** @var string */
    public $username;

    public function __construct(int $uid, string $username)
    {
        $this->uid = $uid;
        $this->username = $username;
    }

    /**
     * Returns class properties as array.
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'uid' => $this->uid,
            'username' => $this->username,
        );
    }

    /**
     * Creates object from array.
     *
     * @param  array $data 
     * @return Shinka_Core_Entity_User
     */
    public function fromArray(array $data)
    {
        return new self(
            $data['uid'],
            $data['username']
        );
    }

    /**
     * Checks whether user has a group-based permission.
     *
     * @param  string   $perm Permission or setting key
     * @param  int|null $uid  Defaults to current session
     * @return boolean
     */
    public static function can(string $perm, $uid = null)
    {
        return Shinka_Core_Service_PermissionService::can($perm, $uid);
    }
}
