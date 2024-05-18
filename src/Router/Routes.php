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
        $this->router->get('/posts', 'Post#index');
        $this->router->get('/posts/:id', 'Post#show');

        // Admin routes
        $this->router->group('/admin', function (Router $router) {
            $router->get('/dashboard', 'Admin#dashboard');
//            $router->get('/posts', 'Admin#posts');
        });
    }

    public function setupPostRoutes(): void
    {
        // Define POST routes here
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
