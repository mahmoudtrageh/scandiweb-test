<?php

// Enable autoloading

use App\Router;

spl_autoload_register(function ($class) {
    // Convert namespace separators to directory separators
    $class = str_replace('\\', '/', $class);
    
    // Base directory for class files
    $baseDir = __DIR__ . '/../';
    
    // Build the file path
    $file = $baseDir . $class . '.php';
    
    // If the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

// Set headers for CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('HTTP/1.1 200 OK');
    exit();
}

// Initialize the router
$router = new Router();

// Extract the request URI path
$requestUri = str_replace('/api/public', '', $_SERVER["REQUEST_URI"]);

// Handle the request
$router->handleRequest($requestUri);