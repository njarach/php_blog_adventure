<?php

namespace src\Service;

class RequestService
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

    public function getRequestMethod(): string {
        return $this->server['REQUEST_METHOD'] ?? 'GET';
    }

    public function getPostData(string $key, $default = null) {
        return $this->post[$key] ?? $default;
    }

    public function getAllPostData(): array {
        return $this->post;
    }
}