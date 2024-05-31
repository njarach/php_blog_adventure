<?php

namespace src\controller;

use Exception;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController
{
    protected function getTwigEnvironment(): Environment
    {
        $loader = new FilesystemLoader('templates');
        return new Environment($loader, [
            'cache' => false,
        ]);
    }

    /**
     * @throws Exception
     */
    protected function render(string $template, array $context = []): string
    {
        try {
            $twig = $this->getTwigEnvironment();
            return $twig->render($template, $context);
        } catch (Exception $e) {
            throw new Exception('A twig exception occurred.');
        }
    }
}