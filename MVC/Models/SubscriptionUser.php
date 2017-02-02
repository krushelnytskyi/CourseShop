<?php

namespace MVC\Models;

use \System\ORM\Model;

/**
 * Class Subscriptions
 * @package MVC\Models
 * @table(subscription_on_user)
 */
class SubscriptionUser extends Model
{

    /**
     * @var int
     * @columnType(INT(11) NOT NULL AUTO_INCREMENT)
     */
    private $id;

    /**
     * @var bool
     * @columnType(TINYINT(1))
     */
    private $positive;

    /**
     * @var int
     * @columnType(INT(11) NOT NULL)
     */
    private $subscriber;

    /**
     * @var int
     * @columnType(INT(11) NOT NULL)
     */
    private $user;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isPositive()
    {
        return $this->positive;
    }

    /**
     * @return int
     */
    public function getSubscriber()
    {
        return $this->subscriber;
    }

    /**
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param bool $positive
     * @return $this
     */
    public function setPositive(bool $positive)
    {
        $this->positive = $positive;
        return $this;
    }

    /**
     * @param int $subscriber
     * @return $this
     */
    public function setSubscriber(int $subscriber)
    {
        $this->subscriber = $subscriber;
        return $this;
    }

    /**
     * @param int $user
     * @return $this
     */
    public function setUser(int $user)
    {
        $this->user = $user;
        return $this;
    }

}