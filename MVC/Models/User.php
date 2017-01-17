<?php

namespace MVC\Models;

/**
 * Class User
 * @package MVC\Models
 * @table(users)
 */
class User
{

    /**
     * User statuses
     */
    const USER_GRADE_BANNED    = -2;
    const USER_GRADE_ONLYREAD  = -1;
    const USER_GRADE_REGULAR   = 0;
    const USER_GRADE_VIP       = 1;
    const USER_GRADE_MODERATOR = 2;
    const USER_GRADE_ADMIN     = 3;

    /**
     * Genders
     */
    const GENDER_MALE   = 2;
    const GENDER_FEMALE = 1;
    const GENDER_UNSET  = 0;

    /**
     * Unique key for User
     *
     * @columnType(INT(11) NOT NULL AUTO_INCREMENT)
     * @var int
     */
    private $id;

    /**
     * User login
     *
     * @columnType(VARCHAR(32) NOT NULL)
     * @var string
     */
    private $name;

    /**
     * Information about user
     *
     * @columnType(TEXT)
     * @var string
     */
    private $about;

    /**
     * User gender
     *
     * @columnType(INT(11))
     * @var int
     */
    private $gender;

    /**
     * User rating.
     * User rating = +2 for each like on his articles,
     * +1 for each like on his comment
     *
     * @columnType(INT(11) NOT NULL)
     * @var int
     */
    private $rating;

    /**
     * User grade,
     *
     * -2 = banned,
     * -1 = onlyRead,
     *  0 = regular,
     *  1 = vip,
     *  2 = moderator,
     *  3 = superModerator
     *
     * @columnType(TINYINT(1) NOT NULL)
     * @var int
     */
    private $grade;

    /**
     * User email
     *
     * @columnType(VARCHAR(127) NOT NULL)
     * @var int
     */
    private $email;

    /**
     * User password
     *
     * @columnType(VARCHAR(32) NOT NULL)
     * @var string
     */
    private $password;

    /**
     * Last login
     *
     * @columnType(TIMESTAMP)
     * @var \DateTime
     */
    private $lastLogin;

    /**
     * @param $password
     * @return bool|string
     */
    public static function encodePassword($password)
    {
        $hash = password_hash(
            $password,
            PASSWORD_BCRYPT,
            [
                'salt' => sha1($password)
            ]
        );

        return $hash;
    }
}