<?php

namespace System\ORM;

/**
 * Class Model
 * @package System\ORM
 */
abstract class Model
{

    /**
     * @var bool
     */
    private $new = true;

    /**
     * @return bool
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * @param bool $new
     */
    public function setNew(bool $new)
    {
        $this->new = $new;
    }

}