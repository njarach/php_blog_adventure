<?php

namespace src\Router;

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
        $this->router->get('/home','Home#home');
        // BlogPost routes
        $this->router->get('/posts', 'Post#index');
        $this->router->get('/posts/:id', 'Post#show');
        // Contact routes
        $this->router->get('/contact','Contact#form');

        // Admin routes
        $this->router->group('/admin', function (Router $router) {
        // Admin Dashboard Routes (if any ???)
            $router->get('/dashboard', 'Admin#dashboard');
        // Admin BlogPost Routes
            $router->get('/posts/edit/:id', 'Post#edit');
            $router->get('/posts/new', 'Post#create');
            $router->get('/posts/delete/:id', 'Post#delete');
        });
    }


    public function setupPostRoutes(): void
    {
        // Comment routes
        $this->router->post('/comments/new/:id', 'Comment#create');
        // Admin Routes
        $this->router->group('/admin',function (Router $router) {
            // Admin BlogPost Routes
            $router->post('/posts/edit/:id', 'Post#edit');
            $router->post('/posts/new', 'Post#create');
        });
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
