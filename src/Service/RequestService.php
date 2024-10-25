<?php

namespace src\Service;

class RequestService
{
    public function getRequestMethod(): string {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    public function getPostData(string $key, $default = null) {
        return $_POST[$key] ?? $default;
    }

    public function getAllPostData(): array {
        return $_POST;
    }

    public function isPost(): bool {
        return $this->getRequestMethod() === 'POST';
    }
}