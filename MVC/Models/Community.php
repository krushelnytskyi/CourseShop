<?php

namespace MVC\Models;


use \System\ORM\Model;

/**
 * Class Community
 * @package MVC\Models
 * @table(communities)
 * @updateBy(id)
 */
class Community extends Model
{

    /**
     * Unique key for Community
     *
     * @columnType(INT(11) UNSIGNED NOT NULL AUTO_INCREMENT KEY)
     * @var int
     */
    private $id;

    /**
     * Creator id
     *
     * @columnType(INT(11) UNSIGNED NOT NULL)
     * @foreignModel(\MVC\Models\User)
     * @foreignField(id)
     * @var User
     */
    private $user;

    /**
     * Name of community
     *
     * @columnType(VARCHAR(400) UNIQUE)
     * @var String
     */
    private $name;

    /**
     * community description and rules
     *
     * @columnType(TEXT)
     * @var string
     */
    private $about;

    /**
     * Option, which enables or disables
     * moderation publications
     * before attachment to the community
     *
     * @columnType(TINYINT(1) UNSIGNED NOT NULL DEFAULT 0)
     * @var boolean
     */
    private $secured;

    /**
     * @param User|int $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return String
     */
    public function getName(): String
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAbout(): string
    {
        return $this->about;
    }

    /**
     * @return bool
     */
    public function isSecured(): bool
    {
        return (bool) $this->secured;
    }

    /**
     * @param String $name
     * @return $this
     */
    public function setName(String $name)
    {
        $this->name = $name;
        return $this;
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
     * @param bool $secured
     * @return $this
     */
    public function setSecured($secured)
    {
        $this->secured = (int) $secured;
        return $this;
    }

}