<?php

require_once __DIR__ . '/../validators/ProductValidator.php';

class Product {
    private $conn; 
    private $table = 'products';

    // Product properties
    private $sku;
    private $name;
    private $price;
    private $size;
    private $weight;
    private $height;
    private $width;
    private $length;

    public function __construct(PDO $db) {
        $this->conn = $db; 
    }

    // Getters and Setters
    public function getSku() {
        return $this->sku;
    }

    public function setSku($sku) {
        $this->sku = $sku;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getSize() {
        return $this->size;
    }

    public function setSize($size) {
        $this->size = $size;
    }

    public function getWeight() {
        return $this->weight;
    }

    public function setWeight($weight) {
        $this->weight = $weight;
    }

    public function getHeight() {
        return $this->height;
    }

    public function setHeight($height) {
        $this->height = $height;
    }

    public function getWidth() {
        return $this->width;
    }

    public function setWidth($width) {
        $this->width = $width;
    }

    public function getLength() {
        return $this->length;
    }

    public function setLength($length) {
        $this->length = $length;
    }

    // Methods
    public function getProducts() {
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createProduct() {
        $productData = json_decode(file_get_contents('php://input'));

        $validator = new ProductValidator($productData, $this->conn);
        $validationResult = $validator->validate();
        
        if (!empty($validationResult)) {
            // Handle validation errors
            echo json_encode(['errors' => $validationResult]);
            exit;
        }

        try {
            // Set product properties
            $this->setSku($productData->sku);
            $this->setName($productData->name);
            $this->setPrice($productData->price);
            $this->setSize($productData->size);
            $this->setWeight($productData->weight);
            $this->setHeight($productData->height);
            $this->setWidth($productData->width);
            $this->setLength($productData->length);
    
            $sql = "INSERT INTO " . $this->table . " (sku, name, price, size, weight, height, width, length) 
                    VALUES (:sku, :name, :price, :size, :weight, :height, :width, :length)";    
    
            $stmt = $this->conn->prepare($sql);
    
            $sku = htmlspecialchars($this->getSku(), ENT_QUOTES, 'UTF-8');
            $name = htmlspecialchars($this->getName(), ENT_QUOTES, 'UTF-8');
            $price = $this->getPrice();
            $size = $this->getSize();
            $weight = $this->getWeight();
            $height = $this->getHeight();
            $width = $this->getWidth();
            $length = $this->getLength();
        
            $stmt->bindParam(':sku', $sku);  
            $stmt->bindParam(':name', $name);    
            $stmt->bindParam(':price', $price);    
            $stmt->bindParam(':size', $size);    
            $stmt->bindParam(':weight', $weight);    
            $stmt->bindParam(':height', $height);    
            $stmt->bindParam(':width', $width);    
            $stmt->bindParam(':length', $length);   
        
            $stmt->execute();
        
        } catch (PDOException $e) {
            return false;            
        }
    }

    public function deleteProducts() {
        $data = json_decode(file_get_contents('php://input'), true);
        $ids = $data['ids'] ?? [];

        if (!empty($ids)) {
            $idString = implode(',', array_map('intval', $ids)); 
            $sql = "DELETE FROM " . $this->table . " WHERE id IN ($idString)";      
            $this->conn->query($sql);
        } 

        return false;
    }
}