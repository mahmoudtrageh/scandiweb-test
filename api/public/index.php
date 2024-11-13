<?php 

require '../src/Router.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$router = new Router();

$requestUri = str_replace('/api/public', '', $_SERVER["REQUEST_URI"]);

$router->handleRequest($requestUri);
