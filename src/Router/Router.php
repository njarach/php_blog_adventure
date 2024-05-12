<?php

namespace src\Router;

// This class contains logic to add routes, and calls on Route object to verify matching and running controller's action.
class Router
{
    private string $url;
    private array $routes = [];

    public function __construct($url){
        $this->url = $url;
    }

    public function get($path, $callable, $name = null): Route
    {
        return $this->add($path, $callable, $name, 'GET');
    }

    public function post($path, $callable, $name = null): Route
    {
        return $this->add($path, $callable, $name, 'POST');
    }

    public function patch($path, $callable, $name = null): Route
    {
        return $this->add($path, $callable, $name, 'PATCH');
    }

    public function delete($path, $callable, $name = null): Route
    {
        return $this->add($path, $callable, $name, 'DELETE');
    }

    private function add($path, $callable, $name, $method): Route
    {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if(is_string($callable) && $name === null){
            $name = $callable;
        }
        if($name){
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    /**
     * @throws RouterException
     */
    public function listen(){
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
            throw new RouterException('REQUEST_METHOD does not exist');
        }
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            if($route->match($this->url)){
                return $route->execute();
            }
        }
        throw new RouterException('No matching routes');
    }
}