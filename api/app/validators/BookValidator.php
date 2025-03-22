<?php

namespace App\Validators;

class BookValidator extends AbstractValidator
{
    public function validate()
    {
        $this->validateRequiredField('weight');
        $this->validateNumeric('weight');
        return $this->getErrors();
    }
}