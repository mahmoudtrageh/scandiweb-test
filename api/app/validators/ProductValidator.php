<?php

require_once __DIR__ . '/../factories/ValidatorFactory.php';

class Validator
{
    private $errors = [];
    private $data; 
    private $conn; 

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

        switch ($this->data->type ?? '') {
            case 'DVD':
                $requiredFields[] = 'size';
                break;
            case 'Book':
                $requiredFields[] = 'weight';
                break;
            case 'Furniture':
                $requiredFields = array_merge($requiredFields, ['height', 'width', 'length']);
                break;
        }
             
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
        
        $validator = ValidatorFactory::create($this->data->type);
        $validator->validate($this->data, $this->errors);
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