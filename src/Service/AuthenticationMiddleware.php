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
            $this->authenticationController->login();
            exit();
        }
    }

    /**
     * @throws Exception
     */
    public function checkAdmin(): void
    {
        $this->checkLoggedIn();
        $user = $this->userManager->getUser(['id' => $_SESSION['user_id']]);
        if ($user) {
            if (!$this->verifyAdminUser($user->getEmail())) {
                $this->authenticationController->login();
                exit();
            }
        }
    }

    private function verifyAdminUser(string $email): bool
    {
        return $email == 'admin@mail.com';
    }

}