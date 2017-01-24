<?php

namespace System;


class Validator
{
    /**
     * @var array
     */
    private $data = array();

    /**
     * @var array
     */
    private $validators = array();

    /**
     * @var array
     */
    private $errors = array();

    /**
     * Validator constructor.
     * @param array $data
     * @param array $validators
     */
    public function __construct(array $data, array $validators)
    {
        $this->data = $data;
        $this->validators = $validators;
    }

    /*
     * * @return array
     */
    public function execute()
    {
        $result = true;
        foreach ($this->validators as $validator) {
            if (!$validator->execute($this->data)) {
                $this->addError($validator->getField(), $validator->getErrorMessage());
                $result = false;
                }
        }
        return $result;
    }

    /**
     * @param $field
     * @param $message
     */
    public function addError($field, $message)
    {
    if (! isset($this->errors[$field])) {
        $this->errors[$field] = array();
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
}