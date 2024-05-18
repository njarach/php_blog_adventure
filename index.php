<?php

use src\Router\Router;
use src\Router\Routes;

require_once 'vendor/autoload.php';

// Router is instantiated with URL as constructor parameter.
$url = $_SERVER['REQUEST_URI'] ?? '/';
$router = new Router($url);

// Routes class contains the routes (called with the setup method)
$routes = new Routes($router);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $routes->setupGetRoutes();
        $router->listen();
    } catch (Exception $e) {
        echo "La route que vous recherchez n'existe pas.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $routes->setupPostRoutes();
        $router->listen();
    } catch (Exception $e) {
        echo "La route que vous recherchez n'existe pas.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    try {
        $routes->setupPatchRoutes();
        $router->listen();
    } catch (Exception $e) {
        echo "La route que vous recherchez n'existe pas.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    try {
        $routes->setupDeleteRoutes();
        $router->listen();
    } catch (Exception $e) {
        echo "La route que vous recherchez n'existe pas.";
    }
}


