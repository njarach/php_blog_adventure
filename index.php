<?php

use src\controller\ErrorController;
use src\Router\Router;
use src\Router\Routes;

require_once 'vendor/autoload.php';

// Router is instantiated with URL as constructor parameter.
$url = $_SERVER['REQUEST_URI'] ?? '/';
$router = new Router($url);
// Routes class contains the routes (called with the setup method)
$routes = new Routes($router);

try {
    $routes->setup();
    $router->listen();
} catch (Exception $e) {
    echo "une erreur est survenue";
}
