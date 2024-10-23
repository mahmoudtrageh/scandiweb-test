<?php

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
        // Validate required fields first
        $this->validateRequiredFields();

        // Return errors if any exist
        if (!empty($this->errors)) {
            return ['errors' => $this->errors[0]];
        } 
        
        $this->checkFieldTypes();
        
        if(!empty($this->errors))
        {
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

    private function checkFieldTypes()
    {
        $this->validateNumeric($this->data->price);
        $this->validateString($this->data->name);

        switch ($this->data->type) {
            case 'DVD':
                $this->validateNumeric($this->data->size);
                break;
            case 'Book':
                $this->validateNumeric($this->data->weight);
                break;
            case 'Furniture':
                foreach (['height', 'width', 'length'] as $dimension) {
                    $this->validateNumeric($this->data->$dimension);
                }
                break;
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