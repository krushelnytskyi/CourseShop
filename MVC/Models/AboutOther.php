<?php

namespace MVC\Models;


/**
 * Class Comment
 * @package MVC\Models
 * @table(aboutOther)
 * record anonymous records about other users
 */
class AboutOther
{

    /**
     * Key for user, who has saved private information about other user
     *
     * @columnType(INT(11) UNSIGNED NOT NULL)
     * @foreignModel(MVC\Models\User)
     * @foreignField(id)
     * @var User
     */
    private $user;

    /**
     * Key for user, about which there is a record
     *
     * @columnType(INT(11) UNSIGNED NOT NULL)
     * @foreignModel(MVC\Models\User)
     * @foreignField(id)
     * @var User
     */
    private $targetUser;

    /**
     * value
     *
     * @columnType(VARCHAR(400) NOT NULL)
     * @var String
     */
    private $value;

    /**
     * AboutOther constructor.
     * @param User $user
     * @param User $targetUser
     * @param String $value
     */
    public function __construct(User $user, User $targetUser, $value)
    {
        $this->user = $user;
        $this->targetUser = $targetUser;
        $this->value = $value;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param User $targetUser
     * @return $this
     */
    public function setTargetUser(User $targetUser)
    {
        $this->targetUser = $targetUser;
        return $this;
    }

    /**
     * @param String $value
     * @return $this
     */
    public function setValue(String $value)
    {
        $this->value = $value;
        return $this;
    }
    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return User
     */
    public function getTargetUser(): User
    {
        return $this->targetUser;
    }

    /**
     * @return String
     */
    public function getValue(): String
    {
        return $this->value;
    }

}