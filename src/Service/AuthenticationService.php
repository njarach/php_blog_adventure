<?php

namespace src\Service;

use Exception;
use src\Model\User;
use src\Service\Manager\UserManager;

class AuthenticationService
{
    private UserManager $userManager;
    public function __construct()
    {
        $this->userManager = new UserManager();
    }

    /**
     * @throws Exception
     */
    public function getUser(string $email): ?User
    {
     return $this->userManager->getUser($email);
    }

    /**
     * @throws Exception
     */
    public function createUser(string $username, string $email, string $hashedPassword): void
    {
        $this->userManager->createUser($username,$email,$hashedPassword);
    }

}