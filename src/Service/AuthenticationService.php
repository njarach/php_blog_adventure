<?php

namespace src\Service;

use src\Model\EntityInterface;
use src\Repository\UserRepository;
use src\Service\Manager\UserManager;

class AuthenticationService
{
    private UserManager $userManager;
    public function __construct()
    {
        $this->userManager = new UserManager();
    }

    public function getUser(string $email): ?EntityInterface
    {
     return $this->userManager->getUser($email);
    }

}