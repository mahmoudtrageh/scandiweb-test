<?php

namespace App\Controllers;

use App\Models\DVDProduct;
use App\Models\ProductFactory;
use App\Validators\ProductValidator;

class ProductController
{
    private $db;
    private $productInstance;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
        // Using DVDProduct as a base instance just for common operations
        $this->productInstance = new DVDProduct($db);
    }

    public function getProducts()
    {
        return $this->productInstance->getAll();
    }

    public function createProduct()
    {
        $productData = json_decode(file_get_contents('php://input'));

        // Validate product data
        $validator = new ProductValidator($productData, $this->db);
        $validationResult = $validator->validate();
        
        if (!empty($validationResult)) {
            echo json_encode($validationResult);
            return false;
        }

        try {
            // Create product instance using factory
            $product = ProductFactory::createProduct($productData, $this->db);
            $result = $product->save();
            
            if ($result) {
                return true;
            } else {
                $errorInfo = "Unknown error";
                // Get the PDO error info if available
                if ($product->getConn() && $product->getConn()->errorInfo()) {
                    $errorInfo = implode(", ", $product->getConn()->errorInfo());
                }
                echo json_encode(['errors' => 'Failed to save product: ' . $errorInfo]);
                return false;
            }
        } catch (\Exception $e) {
            echo json_encode(['errors' => $e->getMessage()]);
            return false;
        }
    }

    public function deleteProducts()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $ids = $data['ids'] ?? [];

        if (!empty($ids)) {
            return $this->productInstance->deleteMultiple($ids);
        }
        
        return false;
    }
}