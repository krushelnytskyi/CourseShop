<?php

namespace MVC\Models;

use System\ORM\Model;

/**
 * Class User
 * @package MVC\Models
 * @table(users)
 * @updateBy(id)
 */
class User extends Model
{

    /**
     * User grade
     */
    const USER_GRADE_BANNED    = -2;
    const USER_GRADE_READONLY  = -1;
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
     * @columnType(INT(11) UNSIGNED NOT NULL AUTO_INCREMENT KEY)
     * @var int
     */
    private $id;

    /**
     * Users nickname for login
     *
     * @columnType(VARCHAR(32) NOT NULL UNIQUE)
     * @var string
     */
    private $nickname;

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
     * @columnType(TINYINT(1) UNSIGNED)
     * @var int
     */
    private $gender;

    /**
     * User rating.
     * User rating = +2 for each like on his articles,
     * +1 for each like on his comment
     *
     * @columnType(INT(11) NOT NULL DEFAULT 0)
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
     * @columnType(TINYINT(1) NOT NULL DEFAULT 0)
     * @var int
     */
    private $grade;

    /**
     * Date when user grade will be returned to 0
     * if unset = forever ban or readonly
     *
     * @columnName(unban_date)
     * @columnType(TIMESTAMP)
     * @var \DateTime
     */
    private $unbanDate;

    /**
     * User email
     *
     * @columnType(VARCHAR(127) NOT NULL UNIQUE)
     * @var int
     */
    private $email;

    /**
     * User password
     *
     * @columnType(VARCHAR(72) NOT NULL)
     * @var string
     */
    private $password;

    /**
     * Last login
     *
     * @columnName(last_login)
     * @columnType(TIMESTAMP)
     * @var \DateTime
     */
    private $lastLogin;

    /**
     * Settings in serialized array
     *
     * @columnType(VARCHAR(1023))
     * @var array
     */
    private $settings;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @return string
     */
    public function getAbout(): string
    {
        return $this->about;
    }

    /**
     * @return int
     */
    public function getGender(): int
    {
        return $this->gender;
    }

    /**
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
    }

    /**
     * @return int
     */
    public function getGrade(): int
    {
        return $this->grade;
    }

    /**
     * @return \DateTime
     */
    public function getUnbanDate(): \DateTime
    {
        return $this->unbanDate;
    }

    /**
     * @return int
     */
    public function getEmail(): int
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return \DateTime
     */
    public function getLastLogin(): \DateTime
    {
        return $this->lastLogin;
    }

    /**
     * @return array
     */
    public function getSettings(): array
    {
        return $this->settings;
    }

    /**
     * @param string $about
     * @return $this
     */
    public function setAbout(string $about)
    {
        $this->about = $about;
        return $this;
    }

    /**
     * @param int $gender
     * @return $this
     */
    public function setGender(int $gender)
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @param int $rating
     * @return $this
     */
    public function setRating(int $rating)
    {
        $this->rating = $rating;
        return $this;
    }

    /**
     * @param int $grade
     * @return $this
     */
    public function setGrade(int $grade)
    {
        $this->grade = $grade;
        return $this;
    }

    /**
     * @param \DateTime $unbanDate
     * @return $this
     */
    public function setUnbanDate(\DateTime $unbanDate)
    {
        $this->unbanDate = $unbanDate;
        return $this;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param \DateTime $lastLogin
     * @return $this
     */
    public function setLastLogin(\DateTime $lastLogin)
    {
        $this->lastLogin = $lastLogin;
        return $this;
    }

    /**
     * @param array $settings
     * @return $this
     */
    public function setSettings(array $settings)
    {
        $this->settings = $settings;
        return $this;
    }

    /**
     * @param string $nickname
     * @return $this
     */
    public function setNickname(string $nickname)
    {
        $this->nickname = $nickname;
        return $this;
    }


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

    public function addRating(int $i = 1){
        $this->rating += $i;
    }

}