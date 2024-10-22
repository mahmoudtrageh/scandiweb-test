<?php 

require '../src/Router.php';

$router = new Router();
$requestUri = str_replace('/public', '', $_SERVER["REQUEST_URI"]);

$router->handleRequest($requestUri);
