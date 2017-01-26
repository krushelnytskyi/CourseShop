<?php

namespace System;
use System\Validators\Validator;

/**
 * Class Form
 * @package System
 */
class Form
{

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var array
     */
    private $errors = [];

    /**
     * @var array
     */
    private $validators = [];

    /**
     * Validator constructor.
     * @param array $data
     * @param array $validators
     */
    public function __construct(array $data = [], array $validators = [])
    {
        $this->data = $data;
        $this->validators = $validators;
    }

    /*
     * * @return array
     */
    public function execute()
    {
        $valid = true;
        foreach ($this->validators as $field => $validators) {
            /** @var Validator $validator */
            foreach ($validators as $validator) {
                if (false === $validator->isValid($this->data[$field])) {
                    $this->addError($field, $validator->getMessage());
                    $valid = false;
                }
            }
        }

        return $valid;
    }

    /**
     * @param $field
     * @param $message
     */
    public function addError($field, $message)
    {
        if (false === isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }

        $this->errors[$field][] = $message;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param $field
     * @return mixed|null
     */
    public function getFieldValue($field)
    {
        return $this->data[$field] ? $this->data[$field] : null;
    }

}