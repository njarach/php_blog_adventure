<?php

namespace src\Service;

use Exception;
use src\Controller\AuthenticationController;
use src\Service\Manager\UserManager;

class AuthenticationMiddleware
{
    private UserManager $userManager;
    private AuthenticationController $authenticationController;

    public function __construct()
    {
        $this->userManager = new UserManager();
        $this->authenticationController = new AuthenticationController();
    }

    /**
     * @throws Exception
     */
    public function checkLoggedIn(): void
    {
        if (!isset($_SESSION['user_id'])) {
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
            $user = $this->userManager->getUser(['id' => $_SESSION['user_id']]);
        } catch (Exception $e) {
            throw new Exception("Action non autorisée, veuillez vous connecter pour réaliser cette action.",402);
        }
        if ($user) {
            if (!$this->verifyAdminUser($user->getEmail())) {
                throw new Exception("Action non autorisée, vous devez être un administrateur pour réaliser cette action.",402);
            }
        }
    }

    private function verifyAdminUser(string $email): bool
    {
        return $email == 'admin@mail.com';
    }

}