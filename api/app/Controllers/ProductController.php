<?php

require '../app/Models/Product.php';

class ProductController {
    private $db;
    private $product;

    public function __construct(PDO $db) {
        $this->product = new Product($db);
    }

    public function getProducts (){
        return $this->product->getProducts();
    }

    public function createProduct() {
        return $this->product->createProduct();
    }

    public function deleteProducts() {
        return $this->product->deleteProducts();
    }

}