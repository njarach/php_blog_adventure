<?php

namespace src\Service;

class Request
{
    private array $post;
    private array $get;
    private array $server;
    public function __construct()
    {
        $this->post = &$_POST;
        $this->get = &$_GET;
        $this->server = &$_SERVER;
    }

    /**
     * @return string Returns the request method (GET is default).
     */
    public function getRequestMethod(): string
    {
        return $this->server['REQUEST_METHOD'] ?? 'GET';
    }

    /**
     * @param string $key
     * @param $default
     * @return mixed|null Returns $_POST data with specified key as parameter.
     */
    public function get(string $key, $default = null): mixed
    {
        return $this->post[$key] ?? $default;
    }

    /**
     * @return array Returns all $_POST data.
     */
    public function getAllPostData(): array
    {
        return $this->post;
    }
}