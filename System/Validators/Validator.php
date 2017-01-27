<?php

namespace System\Validators;

/**
 * Class Validator
 * @package System\Validators
 */
abstract class Validator
{

    /**
     * @var string
     */
    protected $message = '';

    /**
     * @param $value
     * @return bool
     */
    abstract public function isValid($value);

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

}