<?php

namespace MVC\Models;

use \System\ORM\Model;

/**
 * Class SubscriptionOnTag
 * @package MVC\Models
 * @table(subscription_on_community)
 * @updateBy(id)
 */
class SubscriptionCommunity extends Model
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
     * @var int
     * @foreignModel(\MVC\Models\User)
     * @foreignField(id)
     * @columnType(INT(11) NOT NULL)
     */
    private $subscriber;

    /**
     * @var int
     * @foreignModel(\MVC\Models\Community)
     * @foreignField(id)
     * @columnType(INT(11) NOT NULL)
     */
    private $community;

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
     * @return int
     */
    public function getSubscriber()
    {
        return $this->subscriber;
    }

    /**
     * @return int
     */
    public function getCommunity()
    {
        return $this->community;
    }

    /**
     * @param bool $positive
     * @return $this
     */
    public function setPositive(bool $positive)
    {
        $this->positive = (int) $positive;
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
     * @param int $community
     * @return $this
     */
    public function setCommunity(int $community)
    {
        $this->community = $community;
        return $this;
    }

}