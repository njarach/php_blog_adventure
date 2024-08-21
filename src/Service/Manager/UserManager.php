<?php

namespace src\Service\Manager;

use Exception;
use src\Model\User;
use src\Repository\UserRepository;

class UserManager
{
    private UserRepository $userRepository;
    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * @throws Exception
     */
    public function getUser(string $email): ?User
    {
        return $this->userRepository->findOneBy(['email'=>$email]);
    }

}