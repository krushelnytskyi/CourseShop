<?php

namespace MVC\Models;

/**
 * Class Subscriptions
 * @package MVC\Models
 * @table(subscriptions)
 */
class Subscriptions
{
    const SUBSCRIPTION_TYPE_ARTICLE = 1;
    const SUBSCRIPTION_TYPE_TAG     = 2;
    const SUBSCRIPTION_TYPE_USER    = 3;

    /**
     *
     */
    private $id;

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
     * @foreignModel(MVC\Models\Article,MVC\Models\Comment,MVC\Models\Tag)
     * @foreignField(id)
     * @var int
     */
    private $subscriptionType;

}