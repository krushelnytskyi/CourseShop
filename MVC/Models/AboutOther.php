<?php

namespace MVC\Models;


/**
 * Class Comment
 * @package MVC\Models
 * @table(aboutOther)
 * record anonymous records about other users
 */
class AboutOther
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

}