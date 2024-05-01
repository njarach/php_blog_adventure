<?php

use src\Router\Router;

require_once 'vendor/autoload.php';

// Router is instantiated with URL as constructor parameter.
$router = new Router($_GET['url']);

// Routes are defined here. TODO : créer un futur fichier routes.php qui contiendra toutes les routes
$router->get('/posts/','Post#index');
$router->get('/posts/:id', 'Post#show');
$router->listen();
