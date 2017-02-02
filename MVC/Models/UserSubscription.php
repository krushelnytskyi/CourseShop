<?php

namespace MVC\Models;

/**
 * Class Subscriptions
 * @package MVC\Models
 * @table(subscriptions)
 */
class UserSubscription
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
     */
    public function setPositive(bool $positive)
    {
        $this->positive = $positive;
    }

    /**
     * @param int $subscriber
     */
    public function setSubscriber(int $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    /**
     * @param int $user
     */
    public function setUser(int $user)
    {
        $this->user = $user;
    }

}