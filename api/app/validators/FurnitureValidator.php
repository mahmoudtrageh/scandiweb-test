<?php

namespace App\Validators;

class FurnitureValidator extends AbstractValidator
{
    public function validate()
    {
        $dimensions = ['height', 'width', 'length'];
        
        foreach ($dimensions as $dimension) {
            if (!$this->validateRequiredField($dimension)) {
                break;
            }
            $this->validateNumeric($dimension);
        }
        
        return $this->getErrors();
    }
}