<?php

namespace System\Validators;

/**
 * Class Regular
 * @package System\Validators
 */
class Regular extends Validator
{

    /**
     * @var
     */
    protected $pattern;

    /**
     * Regular constructor.
     * @param $pattern
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * @param $value
     * @return bool
     */
    public function isValid($value)
    {
        if (preg_match("/$this->pattern/", $value) !== 1 ) {
        $this->message = 'Incorrect values';
        return false;
        }

        return true;
    }

}
