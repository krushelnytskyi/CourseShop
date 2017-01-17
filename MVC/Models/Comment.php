<?php


namespace MVC\Models;

/**
 * Class User
 * @package MVC\Models
 * @table(Comments)
 */
class Comment
{

    /**
     * Unique key for comment
     *
     * @columnType(INT(11) NOT NULL)
     * @var int
     */
    private $id;

    /**
     * Unique key for article
     *
     * @columnType(INT(11) NOT NULL)
     * @foreignModel(MVC\Models\Article)
     * @foreignField(id)
     * @var Article
     */
    private $article;
    /**
     *
     * Unique key for User
     *
     * @columnType(INT(11) NOT NULL)
     * @foreignModel(MVC\Models\User)
     * @foreignField(id)
     * @var User
     */
    private $user;

    /**
     * Count of likes
     *
     * @columnType(INT(11))
     * @var int
     */
    private $likes;

    /**
     * Count of dislikes
     *
     * @columnType(INT(11))
     * @var int
     */
    private $dislikes;

    /**
     * Body of article
     *
     * @columnType(TEXT)
     * @var String
     */
    private $body;

    /**
     * Date of creation
     *
     * @columnType(TIMESTAMP)
     * @var \DateTime
     */
    private $created;

    /**
     * Parent Id - id of parent article, or parent comment,
     * or something else...
     *
     * @columnType(INT(11) NOT NULL)
     * @foreignModel(MVC\Models\Article,MVC\Models\Comment)
     * @foreignField(id)
     * @var Article|Comment
     */
    private $parent;

    /**
     * Type of parent
     *
     * @columnType(VARCHAR(127))
     *
     * @var string
     */
    private $parentType;

}