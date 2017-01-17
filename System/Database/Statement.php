<?php

namespace System\Database;

abstract class Statement
{

    /**
     * @var string
     */
    protected $table;

    /**
     * @param $table
     * @return $this
     */
    public function from($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @return array|int
     */
    abstract public function execute();
}