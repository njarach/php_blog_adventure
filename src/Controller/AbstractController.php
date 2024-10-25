<?php

namespace src\Controller;

use Exception;
use src\Model\User;
use src\Service\Manager\UserManager;
use src\Service\RequestService;
use src\Service\Response;
use src\Service\ServerService;
use src\Service\SessionService;
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
            throw new Exception("A twig exception occurred : $e");
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
        $sessionUserId = $this->getSessionService()->getSessionUserId();
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
        $sessionUserId = $this->getSessionService()->getSessionUserId();
        $userManager = new UserManager();
        $user = $userManager->getUser(['id'=>$sessionUserId]);
        if (isset($user) && !empty($user) && $user->isAdmin()){
            return true;
        }
        return false;
    }

    protected function getServerService():ServerService
    {
        return new ServerService();
    }

    protected function getSessionService():SessionService
    {
        return new SessionService();
    }

    protected function getRequestService():RequestService
    {
        return new RequestService();
    }
}