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

    /**
     * This sets up all GET method routes so they can be compared and eventually listened.
     * @return void
     */
    public function setupGetRoutes(): void
    {
        // Home routes
        $this->router->get('/', 'Home#home');
        $this->router->get('/download/cv','Home#downloadCv');
        // BlogPost routes
        $this->router->get('/posts', 'Post#index');
        $this->router->get('/posts/:id', 'Post#show');
        // Contact routes
        $this->router->get('/contact', 'Contact#form');
        // Login routes
        $this->router->get('/login', 'Authentication#login');
        $this->router->get('/logout', 'Authentication#logout');
        // Register route
        $this->router->get('/register','Register#register');

        // Admin routes
        $this->router->group('/admin', function (Router $router) {
            // Admin Dashboard
            $router->get('/','AdminDashboard#dashboard');
            // Admin comments routes
            $router->get('/comments', 'Comment#index');
            // Admin BlogPost Routes
            $router->get('/posts', 'Post#index');
            $router->get('/posts/edit/:id', 'Post#edit');
            $router->get('/posts/new', 'Post#create');
            $router->get('/posts/delete/:id', 'Post#delete');
        }, [AuthenticationMiddleware::class, 'checkAdmin']);
    }

    /**
     * This sets up all POST method routes so they can be compared and eventually listened.
     * @return void
     */
    public function setupPostRoutes(): void
    {
        // Logged in routes
        $this->router->group('', function (Router $router) {
            // Comment routes
            $router->post('/comments/new/:id', 'Comment#create');
        }, [AuthenticationMiddleware::class, 'checkLoggedIn']);
        // Login routes
        $this->router->post('/login', 'Authentication#login');
        // Register route
        $this->router->post('/register','Register#register');
        // Send contact email route
        $this->router->post('/contact','Contact#send');
        // Admin Routes
        $this->router->group('/admin', function (Router $router) {
            // Admin BlogPost Routes
            $router->post('/posts/edit/:id', 'Post#edit');
            $router->post('/posts/new', 'Post#create');
            // Admin comments routes
            $router->post('/comments/review/:id', 'Comment#review');
        }, [AuthenticationMiddleware::class, 'checkAdmin']);
    }
}
