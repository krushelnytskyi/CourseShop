<?php


namespace MVC\Models;

/**
 * Class Tag
 * @package MVC\Models
 * @table(Tags)
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
     * @columnType(VARCHAR(32) NOT NULL UNIQUE)
     * @var string
     */
    private $value;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setValue(string $value)
    {
        $this->value = $value;
        return $this;
    }

}