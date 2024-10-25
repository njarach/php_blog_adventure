<?php

namespace src\Service;

class ServerService
{
    public function getRequestUri(): string {
        return $_SERVER['REQUEST_URI'] ?? '/';
    }

}