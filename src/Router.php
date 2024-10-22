<?php
require '../config/db.php';
require '../app/Controllers/ProductController.php';


class Router {
    private $db;
    private $productController;
    private $routes;

    public function __construct() {
        // Initialize the database connection
        $this->db = (new DB())->connect();
        $this->productController = new ProductController($this->db);
        
        // Define a routing map
        $this->routes = [
            '/products/create' => [$this->productController, 'createProduct'],
            '/' => function() {
                echo json_encode($this->productController->getProducts());
            },
            '/products/delete' => [$this->productController, 'deleteProducts'],
        ];
    }
    
    // Function to handle incoming requests
    function handleRequest($uri) {
        $handler = $this->routes[$uri];
        $handler();
    }
}
