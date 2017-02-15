<?php

namespace MVC\Models;

use \System\ORM\Model;

/**
 * Class Subscriptions
 * @package MVC\Models
 * @table(subscription_on_user)
 * @updateBy(id)
 */
class SubscriptionUser extends Model
{

    /**
     * @var int
     * @columnType(INT(11) NOT NULL AUTO_INCREMENT KEY)
     */
    private $id;

    /**
     * @var bool
     * @columnType(TINYINT(1))
     */
    private $positive;

    /**
     * Subscription subject
     *
     * @columnType(INT(11) NOT NULL)
     * @foreignModel(\MVC\Models\User)
     * @foreignField(id)
     * @var User
     */
    private $subscriber;

    /**
     * Subscription target
     *
     * @columnType(INT(11) NOT NULL)
     * @foreignModel(\MVC\Models\User)
     * @foreignField(id)
     * @var User
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
        return (bool) $this->positive;
    }

    /**
     * @return User
     */
    public function getSubscriber()
    {
        return $this->subscriber;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param bool $positive
     * @return $this
     */
    public function setPositive($positive)
    {
        $this->positive = (int) $positive;
        return $this;
    }

    /**
     * @param User $subscriber
     * @return $this
     */
    public function setSubscriber($subscriber)
    {
        $this->subscriber = $subscriber;
        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

}