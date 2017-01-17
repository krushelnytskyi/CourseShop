<?php

namespace MVC\Models;

/**
 * Class Community
 * @package MVC\Models
 * @table(communities)
 */
class Community
{

    /**
     * Unique key for Community
     *
     * @columnType(INT(11) NOT NULL AUTO_INCREMENT)
     * @var int
     */
    private $id;

    /**
     * Creator id
     *
     * @columnType(INT(11) NOT NULL)
     * @foreignModel(MVC\Models\User)
     * @foreignField(id)
     * @var User
     */
    private $user;

    /**
     * Name of community
     *
     * @columnType(VARCHAR(200))
     * @var String
     */
    private $name;

    /**
     * community description and rules
     *
     * @columnType(TEXT)
     * @var string
     */
    private $about;

    /**
     * Option, which enables or disables
     * moderation publications
     * before attachment to the community
     *
     * @columnType(TINYINT(1))
     * @var boolean
     */
    private $secured;

}