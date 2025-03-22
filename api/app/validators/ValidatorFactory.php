<?php

namespace App\Validators;

class ValidatorFactory
{
    private static $validators = [
        'DVD' => DVDValidator::class,
        'Book' => BookValidator::class,
        'Furniture' => FurnitureValidator::class
    ];

    public static function createValidator($data)
    {
        if (!isset($data->type) || !isset(self::$validators[$data->type])) {
            throw new \InvalidArgumentException("Invalid product type");
        }

        $validatorClass = self::$validators[$data->type];
        return new $validatorClass($data); // Don't pass $data to AbstractProduct
    }
}