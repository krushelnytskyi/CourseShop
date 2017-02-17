<?php

namespace MVC\Models;

use \System\ORM\Model;

/**
 * Class SubscriptionOnTag
 * @package MVC\Models
 * @table(subscriptions_on_tag)
 * @updateBy(id)
 */
class SubscriptionTag extends Model
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
     * @foreignModel(\MVC\Models\Tag)
     * @foreignField(id)
     * @columnType(INT(11) NOT NULL)
     */
    private $tag;

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
    public function getTag()
    {
        return $this->tag;
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
     * @param int $tag
     * @return $this
     */
    public function setTag(int $tag)
    {
        $this->tag = $tag;
        return $this;
    }

}