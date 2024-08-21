<?php

use src\Router\Router;
use src\Router\Routes;

require_once 'vendor/autoload.php';

// Start session
session_start();

// Define the base path for your application
$basePath = 'php_blog_adventure';

// Router is instantiated with URL as constructor parameter and base path
$url = $_SERVER['REQUEST_URI'] ?? '/';
$router = new Router($url, $basePath);

// Routes class contains the routes (called with the setup method)
$routes = new Routes($router);

try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $routes->setupGetRoutes();
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
    try {
        $router->handleError(500, $e);
    } catch (Exception $e) {
        echo ('Le controller responsable de la gestion des erreurs a rencontré une erreur.');
        return true;
    }
}
