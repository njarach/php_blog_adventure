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

    /**
     * @return void Echo the content provided to the Response.
     */
    #[NoReturn] public function send(): void
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }
        echo $this->content;
    }

    /**
     * @param string $url The URL the user is redirected to
     * @param int $statusCode
     * @return Response
     */
    public static function redirect(string $url, int $statusCode = 302): Response
    {
        return new self('', $statusCode, ['Location' => $url]);
    }
}