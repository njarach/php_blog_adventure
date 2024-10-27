<?php

namespace src\Service;

class ServerService
{
    private array $server;
    public function __construct()
    {
        $this->server = &$_SERVER;
    }

    /**
     * @return string The current request's URI. '/' is default.
     */
    public function getRequestUri(): string {
        return $this->server['REQUEST_URI'] ?? '/';
    }

}