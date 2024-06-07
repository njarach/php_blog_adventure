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
        $this->router->get('/posts_special','Post#showSpecial');

        // Admin routes
        $this->router->group('/admin', function (Router $router) {
            $router->get('/dashboard', 'Admin#dashboard');
            $router->get('/new_post', 'Post#new');
            $router->get('/edit_post/:id', 'Post#edit');
            $router->get('/delete_post/:id', 'Post#delete');
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
