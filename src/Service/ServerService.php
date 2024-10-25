<?php

namespace src\Service;

class ServerService
{
    private array $server;
    public function __construct()
    {
        $this->server = &$_SERVER;
    }

    public function getRequestUri(): string {
        return $this->server['REQUEST_URI'] ?? '/';
    }

}