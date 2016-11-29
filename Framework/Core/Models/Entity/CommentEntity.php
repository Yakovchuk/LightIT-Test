<?php

namespace App\Core\Models\Entity;

class CommentEntity
{
    /**
     * @var int
     */
    private $parent_id;

    /**
     * @var
     */
    private $email;

    /**
     * @var
     */
    private $text;

    /**
     * CommentEntity constructor.
     * @param $email
     * @param $text
     * @param int $parent_id
     */
    public function __construct($email, $text, $parent_id = 0)
    {
        $this->email        = $email;
        $this->text         = $text;
        $this->parent_id    = $parent_id;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        $validEmail = filter_var($this->email, FILTER_VALIDATE_EMAIL);

        if ( $validEmail && !empty($this->text) ){
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getParentId()
    {
        return $this->parent_id;
    }
}