<?php

namespace MVC\Models;

use System\ORM\Model;

/**
 * Class Article
 * @package MVC\Models
 * @table(articles)
 */
class Article extends Model
{

    /**
     * Unique key for Article
     *
     * @columnType(INT(11) UNSIGNED NOT NULL AUTO_INCREMENT KEY)
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
     * @columnType(VARCHAR(400) NOT NULL)
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
     * @columnType(VARCHAR(1023))
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
     * @columnType(TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)
     * @var \DateTime
     */
    private $created;

    /**
     * Date of last update
     *
     * @columnType(TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
     * @var \DateTime
     */
    private $updated;

    /**
     * @param User $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param int $community
     * @return $this
     */
    public function setCommunity($community)
    {
        $this->community = $community;
        return $this;
    }

    /**
     * @param bool $isModerated
     * @return $this
     */
    public function setIsModerated($isModerated)
    {
        $this->isModerated = $isModerated;
        return $this;
    }

    /**
     * @param String $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param String $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @param String $tags
     * @return $this
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @param float $rating
     * @return $this
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
        return $this;
    }

    /**
     * @param int $likes
     * @return $this
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;
        return $this;
    }

    /**
     * @param int $dislikes
     * @return $this
     */
    public function setDislikes($dislikes)
    {
        $this->dislikes = $dislikes;
        return $this;
    }

    /**
     * @param int $views
     * @return $this
     */
    public function setViews($views)
    {
        $this->views = $views;
        return $this;
    }

    /**
     * @param \DateTime $created
     * @return $this
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @param \DateTime $updated
     * @return $this
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function getCommunity()
    {
        return $this->community;
    }

    /**
     * @return bool
     */
    public function isModerated()
    {
        return $this->isModerated;
    }

    /**
     * @return String
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return String
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return String
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return float
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @return int
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @return int
     */
    public function getDislikes()
    {
        return $this->dislikes;
    }

    /**
     * @return int
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

}
