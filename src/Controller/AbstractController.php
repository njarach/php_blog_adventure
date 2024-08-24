<?php

namespace src\Controller;

use Exception;
use src\Model\User;
use src\Service\Manager\UserManager;
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
            $currentUser = $this->getCurrentUser();
            $context['currentUser'] = $currentUser;
            $twig = $this->getTwigEnvironment();
            return $twig->render($template, $context);
        } catch (Exception $e) {
            throw new Exception("A twig exception occurred : $e");
        }
    }

    protected function redirectToRoute(string $pathLocation): void
    {
        header("Location: $pathLocation");
    }

    /**
     * @throws Exception
     */
    protected function getCurrentUser(): ?User
    {
        if ($_SESSION['user_id']){
            $userManager = new UserManager();
            return $userManager->getUser(['id'=>$_SESSION['user_id']]);
        }
        return null;
    }
}