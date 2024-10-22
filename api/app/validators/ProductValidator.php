<?php
class Validator
{
    private $errors = [];
    private $data;
    private $conn; 
    private $table = 'products';

    public function __construct($data, PDO $db)
    {
        $this->data = $data;
        $this->conn = $db; 
    }

    public function validate()
    {
        // Validate required fields first
        $this->validateRequiredFields();
        if (!empty($this->errors)) {
            return ['errors' => $this->errors[0]]; // Return the first error
        }

        // Validate unique SKU only if no required field errors
        $this->validateUniqueSku();
        if (!empty($this->errors)) {
            return ['errors' => $this->errors[0]]; // Return the first error
        }

    }

    private function validateRequiredFields()
    {
        $requiredFields = ['sku', 'name', 'price', 'type'];

        switch ($this->data->type) {
            case 'dvd_disc':
                $requiredFields[] = 'size';
                break;
            case 'book':
                $requiredFields[] = 'weight';
                break;
            case 'furniture':
                $requiredFields = array_merge($requiredFields, ['height', 'width', 'length']);
                break;
        }
             
        foreach ($requiredFields as $field) {
            if (!isset($this->data->$field) || empty($this->data->$field) && $this->data->$field != 0) {
                $this->errors[] = "Please, submit required data"; // Collect error messages
                break; // Break after the first error
            }
        }

        if (empty($this->errors)) {
            $this->checkFieldTypes();
        }
    }

    private function checkFieldTypes()
    {
        $this->validateNumeric($this->data->price);
        
        $this->validateString($this->data->name);

        switch ($this->data->type) {
            case 'dvd_disc':
                $this->validateNumeric($this->data->size);
                break;
            case 'book':
                $this->validateNumeric($this->data->weight);
                break;
            case 'furniture':
                foreach (['height', 'width', 'length'] as $dimension) {
                    $this->validateNumeric($this->data->$dimension);
                }
                break;
        }
    }

    private function validateNumeric($value)
    {
        if (!isset($value) || !is_numeric($value) || $value <= 0) {
            $this->errors[] = 'Please, provide the data of indicated type';
        }
    }

    private function validateString($value)
    {
        if (!isset($value) || !is_string($value)) {
            $this->errors[] = 'Please, provide the data of indicated type';
        }
    }

    private function validateUniqueSku()
    {
        if ($this->isSkuNotUnique($this->data->sku)) {
            $this->errors[] = 'SKU must be unique.'; // Collect SKU uniqueness error
        }
    }

    private function isSkuNotUnique($sku)
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM " . $this->table . " WHERE sku = :sku");
        $stmt->bindParam(':sku', $sku);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    
        return $count > 0;
    }
}