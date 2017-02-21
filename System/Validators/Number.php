<?php

namespace System\Validators;


class Number extends Validator
{

    protected $min, $max;

    /**
     * Number constructor.
     * @param int|null $min
     * @param int|null $max
     */
    public function __construct($min = null, $max = null)
    {
        $this->min = $min;
        $this->max = $max;
    }


    /**
     * @param $value
     * @return bool
     */
    public function isValid($value)
    {
        if (!is_numeric($value)) {
            $this->message = 'Not a number';
            return false;
        }
        if ($this->min !== null && $value < $this->min) {
            $this->message = 'Incorrect values, min value: ' . $this->min;
            return false;
        }
        if ($this->min !== null && $value > $this->max) {
            $this->message = 'Incorrect values, max value: ' . $this->max;
            return false;
        }
        return true;
    }
}