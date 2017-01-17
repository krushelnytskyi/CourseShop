<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 17.01.2017
 * Time: 1:07
 */

namespace MVC\Models;


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
     * @var int
     */
    private $creatorId;

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
     * @var String
     */
    private $about;

    /**
     * option, which enables or disables moderation publications before attachment to the community
     *
     * @columnType(TINYINT(1))
     * @var boolean
     */
    private $isSecured;

}