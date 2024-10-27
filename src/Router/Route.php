<?php

namespace src\Router;

use Exception;
use src\Service\Response;

class Route
{
    private ?string $path;
    private ?string $callable;
    private array $matches = [];
    private array $params = [];
    private bool $isAdmin;
    private array $middleware = [];

    public function __construct(string $path, $callable, array $middleware){
        $this->path = trim($path, '/');
        $this->callable = $callable;
        $this->isAdmin = str_contains($path, 'admin');
        $this->middleware = $middleware;
    }

    /**
     * Checks if a given URL matches the route's pattern and captures any parameters.
     * @param string $url - The URL to match against the route pattern.
     * @return bool - True if the URL matches the route pattern and parameters are captured; false otherwise.
     */
    public function match(string $url): bool
    {
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $pathToMatch = "#^$path$#i";
        if (preg_match($pathToMatch, $url, $matches)) {
            array_shift($matches);
            $this->matches = $matches;
            return true;
        }
        return false;
    }

    /**
     * Replaces route placeholders (e.g., :id) with regex patterns to capture URL segments.
     * @param array $match Array from preg_replace_callback, where $match[1] is the placeholder name (e.g., "id").
     * @return string Regex pattern for capturing the placeholder segment in the URL.
     */
    private function paramMatch(array $match): string
    {
        if (isset($this->params[$match[1]])) {
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    /**
     * Calls the controller and executes its method, providing the parameters in this object's matches.
     * @throws Exception
     */
    public function execute(): void
    {
        if (is_string($this->callable)) {
            $params = explode('#', $this->callable);
            $namespace = $this->isAdmin ? "src\\Controller\\AdminController\\" : "src\\Controller\\";
            $controller = $namespace . $params[0] . "Controller";
            $controller = new $controller();
            $response = call_user_func_array([$controller, $params[1]], $this->matches);
        } else {
            throw new Exception("Une erreur inattendue s'est produite lors de l'appel du controller et la fonction associée.");
        }

        if ($response instanceof Response) {
            $response->send();
        } else {
            throw new Exception("Une erreur inattendue s'est produite lors de l'envoi de la réponse.");
        }
    }

    /**
     * Returns this Route's middleware. Used in Router listen.
     * @return array An array containing the Middleware class name and the method used.
     */
    public function getMiddleware(): array {
        return $this->middleware;
    }
}
