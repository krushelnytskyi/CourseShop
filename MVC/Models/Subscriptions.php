<?php

namespace MVC\Models;

/**
 * Class Subscriptions
 * @package MVC\Models
 * @table(Subscriptions)
 */
class Subscriptions
{
    const SUBSCRIPTION_TYPE_ARTICLE = 0;
    const SUBSCRIPTION_TYPE_TAG = 1;
    const SUBSCRIPTION_TYPE_USER = 2;

    /**
     * @return bool
     */
    public function isPositive(): bool
    {
        return $this->positive;
    }

    /**
     * @return mixed
     */
    public function getSubscriptionType()
    {
        return $this->subscriptionType;
    }

    /**
     * @return Article|Tag|User
     */
    public function getContentId()
    {
        return $this->contentId;
    }

    /**
     * Key for user, who has subscriptions
     *
     * @columnType(INT(11) UNSIGNED NOT NULL)
     * @foreignModel(MVC\Models\User)
     * @foreignField(id)
     * @var User
     */
    private $user;

    /**
     * Boolean for invert subscriptions to ignore
     *
     * @columnType(TINYINT(1) UNSIGNED)
     * @var boolean
     */
    private $positive;

    /**
     * Boolean for invert subscriptions to ignore
     *
     * @columnType(TINYINT(1) UNSIGNED)
     * @var int
     */
    private $subscriptionType;

    /**
     * Key for subscriptions id
     *
     * @columnType(INT(11) UNSIGNED NOT NULL)
     * @selector(subscriptionType)
     * @foreignModel(MVC\Models\Article,MVC\Models\Tag,MVC\Models\User)
     * @foreignField(id)
     * @var Article|Tag|User
     */
    private $contentId;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
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
     * @param mixed $positive
     * @return $this
     */
    public function setPositive($positive)
    {
        $this->positive = $positive;
        return $this;
    }

    /**
     * @param mixed $subscriptionType
     * @return $this
     */
    public function setSubscriptionType($subscriptionType)
    {
        $this->subscriptionType = $subscriptionType;
        return $this;
    }

    /**
     * @param Article|User|Tag $contentId
     * @return $this
     */
    public function setContentId($contentId)
    {
        $this->contentId = $contentId;
        return $this;
    }




}