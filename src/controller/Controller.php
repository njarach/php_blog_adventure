<?php

namespace src\controller;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class Controller
{
    protected function getTwigEnvironment(): Environment
    {
        $loader = new FilesystemLoader('templates');
        return new Environment($loader, [
            'cache' => false,
        ]);

    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    protected function render(string $template, array $context = []): string
    {
        $twig = $this->getTwigEnvironment();
        return $twig->render($template, $context);
    }
}