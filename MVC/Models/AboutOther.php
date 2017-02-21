<?php

namespace MVC\Models;

use \System\ORM\Model;

/**
 * Class Comment
 * @package MVC\Models
 * @table(about_other)
 * @updateBy(user,targetUser)
 * record anonymous records about other users
 */
class AboutOther extends Model
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
     * @columnName(target_user)
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
     * @param User|int $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->setNew(true);
        $this->user = $user;
        return $this;
    }

    /**
     * @param User|int $targetUser
     * @return $this
     */
    public function setTargetUser($targetUser)
    {
        $this->setNew(true);
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