<?php


namespace MVC\Models;
/**
 * Class Article
 * @package MVC\Models
 * @table(articles)
 */
class Article
{

    /**
     * Unique key for Article
     *
     * @columnType(INT(11) NOT NULL AUTO_INCREMENT)
     * @var int
     */
    private $id;

    /**
     * Unique key for article author
     *
     * @columnType(INT(11) NOT NULL)
     * @foreignModel(MVC\Models\User)
     * @foreignField(id)
     * @var User
     */
    private $user;

    /**
     * Unique key for target community
     *
     * @columnType(INT(11))
     * @foreignModel(MVC\Models\Community)
     * @foreignField(id)
     *
     * @var int
     */
    private $community;

    /**
     * Is confirmed for target community?
     *
     * @columnType(TINYINT(1))
     * @var boolean
     */
    private $isModerated;

    /**
     * Title of article
     *
     * @columnType(VARCHAR(200) NOT NULL)
     * @var String
     */
    private $title;

    /**
     * Body of article
     *
     * @columnType(TEXT)
     * @var String
     */
    private $body;

    /**
     * List of tags id, in database it will be saved in serialized form
     *
     * @columnType(VARCHAR(1023) NOT NULL)
     * @var String
     */
    private $tags = [];

    /**
     * Article rating.
     * Rating is ratio of likes, dislikes
     * and comments to the views and date of create.
     *
     * @columnType(INT(7) NOT NULL)
     * @var float
     */
    private $rating;

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
     * Count of views
     *
     * @columnType(INT(11))
     * @var int
     */
    private $views;

    /**
     * Date of creation
     *
     * @column(TIMESTAMP NOT NULL DEFAULT CURRENT TIMESTAMP)
     * @var \DateTime
     */
    private $created;

    /**
     * Date of last update
     *
     * @column(TIMESTAMP)
     * @var \DateTime
     */
    private $updated;

}