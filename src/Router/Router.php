<?php

namespace src\Router;

use Exception;
use src\controller\ErrorController;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Router
{
    private string $url;
    private string $basePath;
    private array $routes = [];
    private array $namedRoutes = [];
    private string $groupPattern = '';

    public function __construct(string $url, string $basePath = ''){
        $this->url = $url;
        $this->basePath = trim($basePath, '/');
    }

    public function get(string $path, callable $callable, string $name = null): Route
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
        if ($this->groupPattern) {
            $path = $this->groupPattern . $path;
        }

        if ($this->basePath) {
            $path = '/' . $this->basePath . $path;
        }

        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if (is_string($callable) && $name === null) {
            $name = $callable;
        }
        if ($name) {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    public function group(string $pattern, callable $callback): void
    {
        $oldGroupPattern = $this->groupPattern;
        $this->groupPattern .= $pattern;
        call_user_func($callback, $this);
        $this->groupPattern = $oldGroupPattern;
    }

    /**
     * @throws Exception
     */
    public function listen(): mixed {
        try {
            if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
                throw new RouterException('REQUEST_METHOD does not exist');
            }
            /**
             * @var Route[] $routes
             */
            $routes = $this->routes[$_SERVER['REQUEST_METHOD']];
            foreach ($routes as $route) {
                if ($route->match($this->url)) {
                    return $route->execute();
                }
            }
            $this->handleError(404);
        } catch (Exception $e) {
            $this->handleError(500, $e);
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public function handleError(string $errorCode, Exception $exception = null): void
    {
        $errorController = new ErrorController();

        if ($errorCode == 404) {
            $errorController->error404($errorCode);
        } else {
            $errorController->error500($errorCode,$exception);
        }
    }

    /**
     * @throws RouterException
     */
    public function url($name, $params = []){
        if (!isset($this->namedRoutes[$name])) {
            throw new RouterException('No route matches this name');
        }
        return $this->namedRoutes[$name]->getUrl($params);
    }
}
