<?php

namespace MVC\Models;

use \System\ORM\Model;

/**
 * Class Opinions
 * @package MVC\Models
 * @table(opinions)
 * @updateBy(user,contentId)
 * This table for saving likes and dislikes
 */
class Opinions extends Model
{
    const CONTENT_TYPE_ARTICLE = 0;
    const CONTENT_TYPE_COMMENT = 1;

    const LIKE    = 1;
    const DISLIKE = 0;

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
     * Date
     *
     * @columnType(TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)
     * @var \DateTime
     */
    private $date;

    /**
     * Id of article, or comment,
     * or something else...
     *
     * @columnType(INT(11) UNSIGNED NOT NULL)
     * @foreignModel(MVC\Models\Article,MVC\Models\Comment)
     * @foreignField(id)
     * @var Article|Comment
     */
    private $contentId;

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
     * @columnType(TINYINT(1) UNSIGNED NOT NULL)
     * @var int
     */
    private $opinion;

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->setNew(true);
        $this->user = $user;
        return $this;
    }

    /**
     * @param \DateTime $date
     * @return $this
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @param Article|Comment $contentId
     * @return $this
     */
    public function setContentId($contentId)
    {
        $this->setNew(true);
        $this->contentId = $contentId;
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
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @return Article|Comment
     */
    public function getContentId()
    {
        return $this->contentId;
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