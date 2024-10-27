<?php

namespace src\Router;

use Exception;
use JetBrains\PhpStorm\NoReturn;
use src\controller\ErrorController;
use src\Service\Request;

class Router
{
    private string $url;
    private string $basePath;
    private array $routes = [];
    private array $namedRoutes = [];
    private string $groupPattern = '';
    private array $middleware = [];
    private Request $request;

    public function __construct(string $url, string $basePath = ''){
        $this->url = $url;
        $this->basePath = trim($basePath, '/');
        $this->request = new Request();
    }

    /**
     * Adds a new Route with GET method.
     * @param string $path
     * @param $callable
     * @param string|null $name
     * @return Route
     */
    public function get(string $path, $callable, string $name = null): Route
    {
        return $this->add($path, $callable, $name, 'GET');
    }

    /**
     * Adds a new Route with POST method.
     * @param string $path
     * @param $callable
     * @param string|null $name
     * @return Route
     */
    public function post(string $path, $callable, string $name = null): Route
    {
        return $this->add($path, $callable, $name, 'POST');
    }

    /**
     * Creates the Route object to be added when setupGetRoutes or setupPostRoutes is called. Routes are indexed by GET or POST method and added to this object's routes (Route) array.
     * @param $path
     * @param $callable
     * @param $name
     * @param $method
     * @return Route
     */
    private function add($path, $callable, $name, $method): Route
    {
        if ($this->groupPattern) {
            $path = $this->groupPattern . $path;
        }

        if ($this->basePath) {
            $path = '/' . $this->basePath . $path;
        }

        // This creates a Route object
        $route = new Route($path, $callable, $this->middleware);
        // This adds it to this object's $routes array, indexed by HTTP methods
        $this->routes[$method][] = $route;

        if (is_string($callable) && $name === null) {
            $name = $callable;
        }
        if ($name) {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    /**
     * Defines a group pattern and optional middleware for a set of routes.
     * @param string $pattern
     * @param callable $callback
     * @param array|null $middleware
     * @return void
     */
    public function group(string $pattern, callable $callback, array $middleware = null): void
    {
        $oldGroupPattern = $this->groupPattern;
        $this->groupPattern .= $pattern;

        if ($middleware) {
            $this->middleware = $middleware;
        }

        call_user_func($callback, $this);

        $this->groupPattern = $oldGroupPattern;
        $this->middleware = [];
    }

    /**
     * Listens to the provided URL and compares it to registered routes (match). If any matches, then it calls for middleware evaluation (logged in or admin condition) before calling for execution by the Route object.
     * @throws Exception
     */
    public function listen(): void
    {
        try {
            $routes = $this->routes[$this->request->getRequestMethod()];
            foreach ($routes as $route) {
                if ($route->match($this->url)) {
                    $middlewares = $route->getMiddleware();
                    if (!empty($middlewares)) {
                        [$middlewareClass, $middlewareMethod] = $middlewares;
                        if (!class_exists($middlewareClass)) {
                            throw new RouterException("Le Middleware {$middlewareClass} n'existe pas.");
                        }
                        $instance = new $middlewareClass();
                        if (!method_exists($instance, $middlewareMethod)) {
                            throw new RouterException("La méthode {$middlewareMethod} n'existe pas dans le Middleware {$middlewareClass}.");
                        }
                        call_user_func([$instance, $middlewareMethod]);
                    }
                    $route->execute();
                    return;
                }
            }
            throw new RouterException("La page que vous recherchez n'existe pas.", 404);
        } catch (Exception $e) {
            $this->handleError($e->getCode() ?: 500, $e);
        }
    }

    /**
     * Calls for the ErrorController to display an error message. Exceptions are caught and used to be rendered as message. Twig escapes output. Things go very wrong if this breaks though.
     * @throws Exception
     */
    #[NoReturn] public function handleError(int $errorCode, Exception $exception = null): void
    {
        $errorController = new ErrorController();
        $response = $errorController->renderError($errorCode, $exception);
        $response->send();
    }
}
