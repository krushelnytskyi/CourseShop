<?php


namespace MVC\Models;

/**
 * Class Tag
 * @package MVC\Models
 * @table(tags)
 */
class Tag
{
    /**
     * Unique key for tag
     *
     * @columnType(INT(11) UNSIGNED NOT NULL AUTO_INCREMENT KEY)
     * @var int
     */
    private $id;

    /**
     * Tag value
     *
     * @columnType(VARCHAR(32) NOT NULL)
     * @var string
     */
    private $value;

}