<?php

namespace MVC\Models;

use \System\ORM\Model;

/**
 * Class Notifications
 * @package MVC\Models
 * @table(notifications)
 * @updateBy(id)
 */
class Notifications extends Model
{

    /**
     * Unique key for Article
     *
     * @columnType(INT(11) UNSIGNED NOT NULL AUTO_INCREMENT KEY)
     * @var int
     */
    private $id;

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
     * value
     *
     * @columnType(VARCHAR(400) NOT NULL)
     * @var String
     */
    private $value;

    /**
     * Is read?
     *
     * @columnName(is_read)
     * @columnType(TINYINT(1) UNSIGNED NOT NULL)
     * @var boolean
     */
    private $isRead;

    /**
     * Created date
     *
     * @columnType(TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)
     * @var \DateTime
     */
    private $created;

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
     * @param String $value
     * @return $this
     */
    public function setValue(String $value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param bool $isRead
     * @return $this
     */
    public function setIsRead(bool $isRead)
    {
        $this->isRead = $isRead;
        return $this;
    }

    /**
     * @param \DateTime $created
     * @return $this
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
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
     * @return String
     */
    public function getValue(): String
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isIsRead(): bool
    {
        return $this->isRead;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIsRead()
    {
        return $this->isRead;
    }

}