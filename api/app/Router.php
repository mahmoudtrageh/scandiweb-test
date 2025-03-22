<?php

namespace App;

use App\Controllers\ProductController;

class Router
{
    private $db;
    private $productController;
    private $routes;

    public function __construct()
    {
        // Initialize the database connection
        $dbConfig = new \Config\DB();
        $this->db = $dbConfig->connect();
        $this->productController = new ProductController($this->db);
        
        // Define a routing map
        $this->routes = [
            '/products/create' => [$this->productController, 'createProduct'],
            '/' => [$this->productController, 'getProducts'],
            '/products/delete' => [$this->productController, 'deleteProducts'],
        ];
    }
    
    // Function to handle incoming requests
    public function handleRequest($uri)
    {
        if (!isset($this->routes[$uri])) {
            http_response_code(404);
            echo json_encode(['error' => 'Route not found']);
            return;
        }
        
        $handler = $this->routes[$uri];
        $result = call_user_func($handler);
        
        if (is_array($result) || is_object($result)) {
            echo json_encode($result);
        }
    }
}