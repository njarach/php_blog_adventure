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
        // GET Method
        $this->router->get('php_blog_adventure/posts/', 'Post#index','posts');
        $this->router->get('php_blog_adventure/post/:id', 'Post#show','show_post');
        $this->router->get("php_blog_adventure/", 'Post#index','homepage');
        // POST Method
        // PATCH Method
        // DELETE Method
    }
}