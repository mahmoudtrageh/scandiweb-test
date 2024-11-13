<?php

require_once __DIR__ . '/DVDValidator.php';
require_once __DIR__ . '/BookValidator.php';
require_once __DIR__ . '/FurnitureValidator.php';

class ProductValidator
{
    private $errors = [];
    private $data; 
    private $conn; 

    private static $validators = [
        'DVD' => DVDValidator::class,
        'Book' => BookValidator::class,
        'Furniture' => FurnitureValidator::class
    ];

    public function __construct($data, PDO $db)
    {
        $this->data = $data;
        $this->conn = $db; 
    }

    public function validate()
    {
        $this->validateRequiredFields();

        if (!empty($this->errors)) {
            return ['errors' => $this->errors[0]];
        } 
        
        $this->validateFieldTypes();
        
        if (!empty($this->errors)) {
            return ['errors' => $this->errors[0]]; 
        }
        
        return false;
    }

    private function validateRequiredFields()
    {
        $requiredFields = ['sku', 'name', 'price', 'type'];
             
        foreach ($requiredFields as $field) {
            if (!isset($this->data->$field) || (is_null($this->data->$field) || trim($this->data->$field) === '')) {
                $this->errors[] = "Please, submit required data";
                break;
            }
        }
    }

    private function validateFieldTypes()
    {
        $this->validateNumeric($this->data->price);
        $this->validateString($this->data->name);
        
        $validatorClass = self::$validators[$this->data->type] ?? null;

        if ($validatorClass) {
            $validator = new $validatorClass($this->data);
            $result = $validator->validate($this->data, $this->errors);
        } 
    }
    
    private function validateNumeric($value)
    {
        if ($value == '' || $value <= 0) {
            $this->errors[] = 'Please, provide the data of indicated type';
        }
    }

    private function validateString($value)
    {
        if (trim($value) === '') {
            $this->errors[] = 'Please, provide the data of indicated type';
        }
    }
}