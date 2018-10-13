<?php

class Shinka_Core_Entity_Thread extends Shinka_Core_Entity_Entity
{
    /** @var int|null  */
    public $tid;

    /** @var string */
    public $subject;

    /** @var string */
    public $notes;

    public function __construct($tid, string $subject, string $notes)
    {
        $this->tid = $tid;
        $this->subject = $subject;
        $this->notes = $notes;
    }

    /**
     * Returns class properties as array.
     *
     * @return array
     */
    public function toArray()
    {
        $arr = array(
            'subject' => $this->subject,
            'notes' => $this->notes
        );

        if ($this->tid) $arr['tid'] = $this->tid;
        
        return $arr;
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
            $data['tid'],
            $data['subject'],
            $data['notes']
        );
    }
}
