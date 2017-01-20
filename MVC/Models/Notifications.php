<?php

namespace MVC\Models;

/**
 * Class Notifications
 * @package MVC\Models
 * @table(notifications)
 * this model is very raw and needs to be improved!
 */
class Notifications
{
    /**
     * Key for user, who has saved private information about other user
     *
     * @columnType(INT(11) UNSIGNED NOT NULL KEY)
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
     * Like or dislike
     *
     * @columnType(TINYINT(1) UNSIGNED NOT NULL)
     * @var boolean
     */
    private $isRead;

    /**
     *
     *
     * @columnType(TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)
     * @var \DateTime
     */
    private $created;

}