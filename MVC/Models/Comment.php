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
     * @var int
     */
    private $articleId;
    /**
     *
     * Unique key for User
     *
     * @columnType(INT(11) NOT NULL)
     * @var int
     */
    private $autorId;

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
     * @var String
     */
    private $created;

    /**
     * Parent Id - id of parent article, or parent comment, or something else...
     *
     * @columnType(INT(11) NOT NULL)
     * @var int
     */
    private $ParentId;

    /**
     * Type of parent
     *
     * @columnType(TINYINT(1))
     * @var String
     */
    private $ParetnType;


}