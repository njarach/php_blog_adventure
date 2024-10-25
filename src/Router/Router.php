<?php

namespace src\Router;

use Exception;
use src\controller\ErrorController;
use src\Service\RequestService;

class Router
{
    private string $url;
    private string $basePath;
    private array $routes = [];
    private array $namedRoutes = [];
    private string $groupPattern = '';
    private array $middleware = [];
    private RequestService $requestService;

    public function __construct(string $url, string $basePath = ''){
        $this->url = $url;
        $this->basePath = trim($basePath, '/');
        $this->requestService = new RequestService();
    }

    public function get(string $path, $callable, string $name = null): Route
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

        $route = new Route($path, $callable, $this->middleware);
        $this->routes[$method][] = $route;
        if (is_string($callable) && $name === null) {
            $name = $callable;
        }
        if ($name) {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

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
     * @throws Exception
     */
    public function listen(): void
    {
        try {
            if (!isset($this->routes[$this->requestService->getRequestMethod()])) {
                throw new RouterException('La méthode de la requête n\'existe pas.');
            }
            $routes = $this->routes[$this->requestService->getRequestMethod()];
            foreach ($routes as $route) {
                if ($route->match($this->url)) {

                    $middlewares = $route->getMiddleware();
                    if (!empty($middlewares)) {
                        if (!is_array($middlewares) || count($middlewares) !== 2) {
                            throw new RouterException("Middleware is not structured correctly: " . json_encode($middlewares));
                        }
                        [$middlewareClass, $middlewareMethod] = $middlewares;
                        if (!class_exists($middlewareClass)) {
                            throw new RouterException("Middleware class {$middlewareClass} does not exist.");
                        }
                        $instance = new $middlewareClass();
                        if (!method_exists($instance, $middlewareMethod)) {
                            throw new RouterException("Method {$middlewareMethod} does not exist on middleware class {$middlewareClass}.");
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
     * @throws Exception
     */
    public function handleError(int $errorCode, Exception $exception = null): void
    {
        $errorController = new ErrorController();
        $response = $errorController->renderError($errorCode, $exception);
        $response->send();
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
