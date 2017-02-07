<?php

namespace System\Pattern;

/**
 * Class Singleton
 * @package System\Pattern
 */
trait Singleton
{

    /**
     * @var null|object
     */
    private static $instance;

    /**
     * @return null|object
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

}