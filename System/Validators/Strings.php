<?php

namespace System\Validators;

/**
 * Class Strings
 * @package System\Validators
 */
class Strings extends Validator
{

    /**
     * @param $value
     * @return bool
     */
    public function isValid($value)
    {
        $string = mb_strlen($value);

        if ($string < 8 || $string > 64) {
            $this->message = 'Must be between 8 and 64 chars';
            return false;
        }

        return true;
    }

}
