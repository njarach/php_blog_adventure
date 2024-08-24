<?php

namespace src\Router;

use src\Service\AuthenticationMiddleware;

class Routes
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function setupGetRoutes(): void
    {
        // Home routes
        $this->router->get('/home', 'Home#home');
        // BlogPost routes
        $this->router->get('/posts', 'Post#index');
        $this->router->get('/posts/:id', 'Post#show');
        // Contact routes
        $this->router->get('/contact', 'Contact#form');
        // Login routes
        $this->router->get('/login', 'Authentication#login');

        // Admin routes
        $this->router->group('/admin', function (Router $router) {
            // Admin comments routes
            $router->get('/comments', 'Comment#index');
            // Admin BlogPost Routes
            $router->get('/posts', 'Post#index');
            $router->get('/posts/edit/:id', 'Post#edit');
            $router->get('/posts/new', 'Post#create');
            $router->get('/posts/delete/:id', 'Post#delete');
            // Admin register user
            $router->get('/register', 'Register#register');
        }, [AuthenticationMiddleware::class, 'checkAdmin']);
    }

    public function setupPostRoutes(): void
    {
        // Logged in routes
        $this->router->group('', function (Router $router) {
            // Comment routes
            $router->post('/comments/new/:id', 'Comment#create');
        }, [AuthenticationMiddleware::class, 'checkLoggedIn']);

        // Login routes
        $this->router->post('/login', 'Authentication#login');
        // Admin Routes
        $this->router->group('/admin', function (Router $router) {
            // Admin BlogPost Routes
            $router->post('/posts/edit/:id', 'Post#edit');
            $router->post('/posts/new', 'Post#create');
            // Admin comments routes
            $router->post('/comments/review/:id', 'Comment#review');
            // Admin register user
            $router->post('/register','Register#register');
        }, [AuthenticationMiddleware::class, 'checkAdmin']);
    }

    public function setupPatchRoutes(): void
    {
        // Define PATCH routes here
    }

    public function setupDeleteRoutes(): void
    {
        // Define DELETE routes here
    }
}
