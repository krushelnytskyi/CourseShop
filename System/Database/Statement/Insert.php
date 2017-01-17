<?php

namespace System\Database\Statement;

use System\Database\Statement;

class Insert extends Statement
{

    /**
     * @var array
     */
    private $values = [];

    /**
     * @param $values
     * @return $this
     */
    public function values($values)
    {
        $this->values = $values;
        return $this;
    }

    /**
     *
     */
    public function execute()
    {

    }

}