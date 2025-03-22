<?php

namespace App\Validators;

abstract class AbstractValidator
{
    protected $data;
    protected $errors = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    protected function addError($message)
    {
        $this->errors[] = $message;
    }

    protected function validateRequiredField($field)
    {
        if (!isset($this->data->$field) || (is_null($this->data->$field) || trim($this->data->$field) === '')) {
            $this->addError("Please, submit required data");
            return false;
        }
        return true;
    }

    protected function validateNumeric($field)
    {
        if (empty($this->data->$field) || $this->data->$field <= 0) {
            $this->addError('Please, provide the data of indicated type');
            return false;
        }
        return true;
    }

    protected function validateString($field)
    {
        if (trim($this->data->$field) === '') {
            $this->addError('Please, provide the data of indicated type');
            return false;
        }
        return true;
    }

    abstract public function validate();
}