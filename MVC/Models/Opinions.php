<?php

namespace MVC\Models;

/**
 * Class Opinions
 * @package MVC\Models
 * @table(opinions)
 * This table for saving likes and dislikes
 */
class Opinions
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


}