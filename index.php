<?php

use src\Router\Router;
use src\Router\Routes;

require_once 'vendor/autoload.php';

// Define the base path for your application
$basePath = 'php_blog_adventure';

// Router is instantiated with URL as constructor parameter and base path
$url = $_SERVER['REQUEST_URI'] ?? '/';
$router = new Router($url, $basePath);

// Routes class contains the routes (called with the setup method)
$routes = new Routes($router);

try {
    $routes->setupGetRoutes();
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $router->listen();
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $routes->setupPostRoutes();
        $router->listen();
    } elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
        $routes->setupPatchRoutes();
        $router->listen();
    } elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        $routes->setupDeleteRoutes();
        $router->listen();
    }
} catch (Exception $e) {
    $router->handleError(500, $e);
}
