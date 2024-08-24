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
    public function getUser(array $criteria): ?User
    {
        return $this->userRepository->findOneBy($criteria);
    }

    /**
     * @throws Exception
     */
    public function createUser(string $username, string $email, string $hashedPassword): void
    {
        $user = new User();
        $user->setEmail($email);
        $user->setUsername($username);
        $user->setPassword($hashedPassword);
        $currentDateTime = date('Y-m-d H:i:s');
        $user->setCreatedAt($currentDateTime);
        $this->userRepository->add($user);
    }

}