<?php

namespace src\Router;

class Route
{
    private ?string $path;
    private ?string $action;
    private array $matches = [];
    private array $params = [];
    private bool $isAdmin;

    public function __construct($path, $action){
        $this->path = trim($path, '/');
        $this->action = $action;
        $this->isAdmin = str_contains($path, 'admin');
    }

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

    private function paramMatch($match): string
    {
        if (isset($this->params[$match[1]])) {
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    public function execute()
    {
        if (is_string($this->action)) {
            $params = explode('#', $this->action);
            $namespace = $this->isAdmin ? "src\\Controller\\AdminController\\" : "src\\Controller\\";
            $controller = $namespace . $params[0] . "Controller";
            $controller = new $controller();
            return call_user_func_array([$controller, $params[1]], $this->matches);
        } else {
            return call_user_func_array($this->action, $this->matches);
        }
    }

    public function getUrl($params): array|string|null
    {
        $path = $this->path;
        foreach ($params as $k => $v) {
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }
}
