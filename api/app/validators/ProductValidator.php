<?php

namespace App\Validators;

class ProductValidator
{
    private $data;
    private $conn;
    private $requiredFields = ['sku', 'name', 'price', 'type'];

    public function __construct($data, \PDO $db)
    {
        $this->data = $data;
        $this->conn = $db;
    }

    public function validate()
    {
        // Validate common required fields
        foreach ($this->requiredFields as $field) {
            if (!isset($this->data->$field) || (is_null($this->data->$field) || trim($this->data->$field) === '')) {
                return ['errors' => "Please, submit required data"];
            }
        }

        // Validate common field types
        if ($this->data->price == '' || $this->data->price <= 0) {
            return ['errors' => 'Please, provide the data of indicated type'];
        }

        if (trim($this->data->name) === '') {
            return ['errors' => 'Please, provide the data of indicated type'];
        }

        // Check for duplicate SKU
        $sql = "SELECT COUNT(*) as count FROM products WHERE sku = :sku";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':sku', $this->data->sku);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($result['count'] > 0) {
            return ['errors' => 'SKU already exists'];
        }

        // Validate specific product type fields using a type-specific validator
        try {
            $typeValidator = ValidatorFactory::createValidator($this->data);
            $errors = [];
            $typeValidator->validate($errors);
            
            if (count($errors) > 0) {
                return ['errors' => $errors[0]];
            }
        } catch (\Exception $e) {
            return ['errors' => $e->getMessage()];
        }

        return false;
    }
}