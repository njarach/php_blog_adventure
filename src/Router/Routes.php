<?php

namespace src\Router;

class Routes
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function setupGetRoutes():void
    {
        //        Example of a specific scope route
        //        $this->router->scope('/admin', function($router) {
        //            $this->router->get('/delete/:slug/:id', 'Users#delete');
        //        });
        // GET Method
        $this->router->get('php_blog_adventure/posts/', 'Post#index','posts');
        $this->router->get('php_blog_adventure/posts/:id', 'Post#show','show_post');
        $this->router->get("php_blog_adventure/", 'Post#index','homepage');
    }

    public function setupPostRoutes(): void
    {
        // POST Method
    }

    public function setupPatchRoutes(): void
    {
        // PATCH Method
    }

    public function setupDeleteRoutes(): void
    {
        // DELETE Method
    }
}