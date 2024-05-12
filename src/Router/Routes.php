<?php

namespace src\Router;

class Routes
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function setup():void
    {
        $this->router->get('php_blog_adventure/posts/', 'Post#index');
        $this->router->get('php_blog_adventure/post/:id', 'Post#show');
        $this->router->get("php_blog_adventure/", 'Post#index');
    }
}