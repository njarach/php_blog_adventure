<?php

namespace src\controller;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
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
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    protected function render(string $template, array $context = []): string
    {
        try {
            $twig = $this->getTwigEnvironment();
            return $twig->render($template, $context);
        } catch (LoaderError $e) {
            throw new LoaderError('A twig LoaderError occurred.');
        } catch (RuntimeError $e) {
            throw new RuntimeError('A twig RuntimeError occurred.');
        } catch (SyntaxError $e) {
            throw new SyntaxError('A twig SyntaxError occurred.');
        }
    }
}