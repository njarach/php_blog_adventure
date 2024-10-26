<?php

namespace src\Service;

use JetBrains\PhpStorm\NoReturn;

class Response
{
    protected string $content;
    protected int $statusCode;
    protected array $headers;

    public function __construct(string $content = '', int $statusCode = 200, array $headers = [])
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    #[NoReturn] public function send(): void
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        echo $this->content;
    }

    public static function redirect(string $url, int $statusCode = 302): Response
    {
        return new self('', $statusCode, ['Location' => $url]);
    }
}