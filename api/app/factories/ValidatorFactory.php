<?php

require_once __DIR__ . '/../validators/DVDValidator.php';
require_once __DIR__ . '/../validators/BookValidator.php';
require_once __DIR__ . '/../validators/FurnitureValidator.php';

class ValidatorFactory
{
    public static function create($type): Validator
    {
        switch ($type) {
            case 'DVD':
                return new DVDValidator();
            case 'Book':
                return new BookValidator();
            case 'Furniture':
                return new FurnitureValidator();
            default:
                throw new Exception("Invalid product type");
        }
    }
}