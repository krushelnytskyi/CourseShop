<?php

namespace System\Database\Statement;


class IndpndtConditions extends Condition
{

    /**
     * IndpndtConditions constructor.
     */
    public function __construct()
    {
        parent::__construct(null);
    }



    /**
     * @return string
     */
    public function closeCondition()
    {
        if (true === $this->blocked) {
             return('WHERE ' . $this->condition);
        }
    }

}