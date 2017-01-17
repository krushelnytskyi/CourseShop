<?php

namespace MVC\Models;

/**
 * Class User
 * @package MVC\Models
 * @table(Users)
 */
class User
{

    const USER_GRADE_BANNED = -2;
    const USER_GRADE_ONLYREAD = -1;
    const USER_GRADE_REGULAR = 0;
    const USER_GRADE_VIP = 1;
    const USER_GRADE_MODERATOR = 2;
    const USER_GRADE_ADMIN = 3;

    const GENDER_MALE = 2;
    const GENDER_FEMALE = 1;
    const GENDER_UNSET = 0;

    /**
     * Unique key for User
     *
     * @columnType(INT(11) NOT NULL AUTO_INCREMENT)
     * @var int
     */
    private $Id;

    /**
     * User login
     *
     * @columnType(VARCHAR(32) NOT NULL)
     * @var String
     */
    private $login;

    /**
     * Information about user
     *
     * @columnType(TEXT)
     * @var String
     */
    private $aboutUser;

    /**
     * User gender
     *
     * @columnType(INT(11))
     * @var int
     */
    private $gender;

    /**
     * User rating.
     * User rating = +2 for each like on his articles, +1 for each like on his comment
     *
     * @columnType(INT(11) NOT NULL)
     * @var int
     */
    private $rating;

    /**
     * User grade,
     * -2 = banned, -1 = onlyRead, 0 = regular, 1 = vip, 2=moderator, 3=superModerator
     *
     * @columnType(TINYINT(1) NOT NULL)
     * @var int
     */
    private $grade;

    /**
     * User email
     *
     * @columnType(VARCHAR(64) NOT NULL)
     * @var int
     */
    private $email;

    /**
     * User password
     *
     * @columnType(VARCHAR(32) NOT NULL)
     * @var String
     */
    private $pass;

    /**
     * Last login
     *
     * @columnType(TIMESTAMP)
     * @var int
     */
    private $lastLogin;
}