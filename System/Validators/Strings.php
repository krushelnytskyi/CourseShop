<?php

namespace System\Validators;

/**
 * Class Strings
 * @package System\Validators
 */
class Strings extends Validator
{
    /**
     * @var
     */
    protected $min;

    /**
     * @var
     */
    protected $max;

    /**
     * Strings constructor.
     * @param $min
     * @param $max
     */
    public function __construct($min, $max)
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
        $string = mb_strlen($value);

        if ($string < $this->min || $string > $this->max) {
            $this->message = 'Incorrect length of characters! Min: ' . $this->min . '. Max: ' . $this->max.'.';
            return false;
        }

        return true;
    }

}
