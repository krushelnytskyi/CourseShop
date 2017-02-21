<?php

namespace MVC\Models;

use \System\ORM\Model;

/**
 * Class Opinions
 * @package MVC\Models
 * @table(opinions)
 * @updateBy(id)
 * This table for saving likes and dislikes
 */
class Opinions extends Model
{
    const CONTENT_TYPE_ARTICLE = 0;
    const CONTENT_TYPE_COMMENT = 1;

    const LIKE    = 1;
    const DISLIKE = 0;

    /**
     * Unique key for opinion
     *
     * @columnType(INT(11) UNSIGNED NOT NULL AUTO_INCREMENT KEY)
     * @var int
     */
    private $id;

    /**
     * Key for user, who have opinion about something (like or dislike)
     *
     * @columnType(INT(11) UNSIGNED NOT NULL)
     * @foreignModel(MVC\Models\User)
     * @foreignField(id)
     * @var User
     */
    private $user;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Id of article, or comment,
     * or something else...
     *
     * @columnName(content_id)
     * @columnType(INT(11) UNSIGNED NOT NULL)
     * @selector(content_type)
     * @foreignModel(MVC\Models\Article,MVC\Models\Comment)
     * @foreignField(id)
     * @var Article|Comment
     */
    private $content;

    /**
     * Type of content
     *
     *
     * @columnName(content_type)
     * @columnType(TINYINT(1) UNSIGNED NOT NULL)
     * @var int
     */
    private $contentType;

    /**
     * Like or dislike
     *
     * @columnType(TINYINT(1) UNSIGNED NOT NULL DEFAULT 0)
     * @var int
     */
    private $opinion;

    /**
     * @param User|int $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->setNew(true);
        $this->user = $user;
        return $this;
    }

    /**
     * @param Article|Comment|int $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->setNew(true);
        $this->content = $content;
        return $this;
    }

    /**
     * @param int $contentType
     * @return $this
     */
    public function setContentType(int $contentType)
    {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * @param int $opinion
     * @return $this
     */
    public function setOpinion(int $opinion)
    {
        $this->opinion = $opinion;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Article|Comment
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getContentType(): int
    {
        return $this->contentType;
    }

    /**
     * @return int
     */
    public function getOpinion(): int
    {
        return $this->opinion;
    }


}