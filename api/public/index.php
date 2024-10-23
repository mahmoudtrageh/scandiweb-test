<?php 

require '../src/Router.php';

$router = new Router();

$requestUri = str_replace('/api/public', '', $_SERVER["REQUEST_URI"]);

$router->handleRequest($requestUri);
