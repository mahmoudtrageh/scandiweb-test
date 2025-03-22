<?php

namespace App\Validators;

class DVDValidator extends AbstractValidator
{
    public function validate()
    {
        $this->validateRequiredField('size');
        $this->validateNumeric('size');
        return $this->getErrors();
    }
}