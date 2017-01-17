<?php

namespace MVC\Models;

/**
 * Class User
 * @package MVC\Models
 * @table(UsersSettings)
 */
class UserSetings
{
    /**
     * Unique key for User
     *
     * @columnType(INT(11) NOT NULL)
     * @var int
     */
    private $id;

    /**
     * Count of articles per page
     *
     * @columnType((TINYINT(2))
     * @var int
     */
    private $articlesPerPage;

    /**
     * Hide article if article->rating < minArticleRating.
     * value: 0 > minCommentRating >= -101, if -101 - do not hide comment;
     *
     * @columnType(TINYINT(1))
     * @var int
     */
    private $minArticleRating;

    /**
     * Hide comment if comment->rating < minCommentRating.
     * value: 0 > minCommentRating >= -21, if -21 - do not hide comment;
     *
     * @columnType(TINYINT(1))
     * @var int
     */
    private $minCommentsRating;

    /**
     * Autoload gif? Or load by click?
     *
     * @columnType(TINYINT(1))
     * @var boolean
     */
    private $autoloadGif;

    /**
     * Show nsfw?
     *
     * @columnType(TINYINT(1))
     * @var boolean
     */
    private $showNsfw;

}