<?php

namespace MVC\Models;

/**
 * Class Tag
 * @package MVC\Models
 * @table(tagsInArticle)
 */
class TagsInArticle
{
    /**
     * key for Article
     *
     * @columnType(INT(11) UNSIGNED NOT NULL)
     * @foreignModel(MVC\Models\Article)
     * @foreignField(id)
     * @var Article
     */
    private $article;

    /**
     * key for tag
     *
     * @columnType(INT(11) UNSIGNED NOT NULL)
     * @var Tag
     */
    private $tag;

}