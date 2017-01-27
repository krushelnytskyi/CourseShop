<?php

namespace System\Validators;

/**
 * Class Email
 * @package System\Validators
 */
class Email extends Validator
{

    /**
     * @param $value
     * @return bool
     */
    public function isValid($value)
    {
        $parts = explode('@', $value);
        if (count($parts) !== 2) {
            $this->message = 'Bad email address';
            return false;
        }
        $len = mb_strlen($parts[0]);
        if ($len === 0 || $len > 64) {
            $this->message = 'Bad email address';
            return false;
        }
        $len = mb_strlen($parts[1]);
        if ($len === 0 || $len > 255) {
            $this->message = 'Bad email address';
            return false;
                    }
        if ($parts[0]{0} === '.') {
            $this->message = 'Bad email address';
            return false;
        }
        if (strpos($parts[0], '..') !== false || strpos($parts[1], '..') !== false) {
            $this->message = 'Bad email address';
            return false;

        }

        return true;
    }

}
