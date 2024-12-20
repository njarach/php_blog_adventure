<?php

namespace src\Controller;

use Exception;
use src\Model\User;
use src\Service\Manager\UserManager;
use src\Service\Request;
use src\Service\Response;
use src\Service\ServerService;
use src\Service\Session;
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
    protected function render(string $template, array $context = []): Response
    {
        try {
            $currentUser = $this->getCurrentUser();
            $roleAdmin = $this->checkUserAdmin();
            $context['currentUser'] = $currentUser;
            $context['roleAdmin'] = $roleAdmin;
            $twig = $this->getTwigEnvironment();
            $content = $twig->render($template, $context);
            return new Response($content);
        } catch (Exception $e) {
            $escapedMessage = htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
            throw new Exception("Une erreur Twig s'est produite: " . $escapedMessage);
        }
    }

    protected function redirect(string $url, int $statusCode = 302): Response
    {
        return Response::redirect($url, $statusCode);
    }

    /**
     * @throws Exception
     */
    protected function getCurrentUser(): ?User
    {
        $sessionUserId = $this->session()->getSessionUserId();
        if (!isset($sessionUserId)){
            return null;
        }
        $userManager = new UserManager();
        return $userManager->getUser(['id'=>$sessionUserId]);
    }

    /**
     * @throws Exception
     */
    protected function checkUserAdmin(): bool
    {
        $sessionUserId = $this->session()->getSessionUserId();
        $userManager = new UserManager();
        if (isset($sessionUserId)){
            $user = $userManager->getUser(['id'=>$sessionUserId]);;
        }
        if (isset($user) && !empty($user) && $user->isAdmin()){
            return true;
        }
        return false;
    }

    protected function server():ServerService
    {
        return new ServerService();
    }

    protected function session():Session
    {
        return new Session();
    }

    protected function request():Request
    {
        return new Request();
    }
}