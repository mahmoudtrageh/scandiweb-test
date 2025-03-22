<?php

namespace App\Models;

class ProductFactory
{
    private static $productTypes = [
        'DVD' => DVDProduct::class,
        'Book' => BookProduct::class,
        'Furniture' => FurnitureProduct::class
    ];

    public static function createProduct($data, \PDO $db)
    {
        if (!isset($data->type) || !isset(self::$productTypes[$data->type])) {
            throw new \InvalidArgumentException("Invalid product type");
        }

        $productClass = self::$productTypes[$data->type];
        return $productClass::createFromData($data, $db);
    }
}