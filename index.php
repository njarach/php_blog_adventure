<?php

use src\Router\Router;
use src\Router\Routes;
use src\Service\RequestService;
use src\Service\ServerService;
use src\Service\SessionService;

require_once 'vendor/autoload.php';

date_default_timezone_set('Europe/Paris');

$serverService = new ServerService();
$requestService = new RequestService();
$sessionService = new SessionService();

$sessionService->startSession();

$basePath = 'php_blog_adventure';

$url = $serverService->getRequestUri();
$router = new Router($url, $basePath);

$routes = new Routes($router);

try {
    if ($requestService->getRequestMethod() == 'GET') {
        $routes->setupGetRoutes();
        $router->listen();
    } elseif ($requestService->getRequestMethod() == 'POST') {
        $routes->setupPostRoutes();
        $router->listen();
    } elseif ($requestService->getRequestMethod() == 'PATCH') {
        $routes->setupPatchRoutes();
        $router->listen();
    } elseif ($requestService->getRequestMethod() == 'DELETE') {
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
