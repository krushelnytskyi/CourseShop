<?php

namespace MVC\Models;

use \System\ORM\Model;

/**
 * Class Tag
 * @package MVC\Models
 * @table(tags_in_article)
 */
class TagsInArticle extends Model
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
     * @foreignModel(MVC\Models\Tag)
     * @foreignField(id)
     * @var Tag
     */
    private $tag;

    /**
     * @param Article|int $article
     * @return $this
     */
    public function setArticle($article)
    {
        $this->article = $article;
        return $this;
    }

    /**
     * @param Tag|int $tag
     * @return $this
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
        return $this;
    }


    /**
     * @return Article
     */
    public function getArticle(): Article
    {
        return $this->article;
    }

    /**
     * @return Tag
     */
    public function getTag(): Tag
    {
        return $this->tag;
    }

}