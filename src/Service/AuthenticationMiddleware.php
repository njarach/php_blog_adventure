<?php

namespace src\Service;

use Exception;
use src\Controller\AuthenticationController;
use src\Service\Manager\UserManager;

class AuthenticationMiddleware
{
    private UserManager $userManager;
    private SessionService $sessionService;

    public function __construct()
    {
        $this->userManager = new UserManager();
        $this->sessionService = new SessionService();
    }

    /**
     * @throws Exception
     */
    public function checkLoggedIn(): void
    {
        $sessionUserId = $this->sessionService->getSessionUserId();
        if (!isset($sessionUserId)) {
            throw new Exception("Action non autorisée, veuillez vous connecter pour réaliser cette action.",402);
        }
    }

    /**
     * @throws Exception
     */
    public function checkAdmin(): void
    {
        try {
            $this->checkLoggedIn();
            $user = $this->userManager->getUser(['id' => $this->sessionService->getSessionUserId()]);
        } catch (Exception $e) {
            throw new Exception("Action non autorisée, veuillez vous connecter pour réaliser cette action.",402);
        }
        if ($user) {
            if (!$this->verifyAdminUser($user->isAdmin())) {
                throw new Exception("Action non autorisée, vous devez être un administrateur pour réaliser cette action.",402);
            }
        }
    }

    private function verifyAdminUser(bool $isAdmin): bool
    {
        return $isAdmin;
    }

}