<?php

namespace src\Service;


use src\Model\User;

class AuthenticationService
{
    private array $errors = [];
    private SessionService $sessionService;

    public function __construct()
    {
        $this->sessionService = new SessionService();
    }

    public function endSession(): void
    {
       $this->sessionService->endSession();
    }

    public function validateLoginData(array $_POST): array
    {
        $errors = $this->errors;
        $email = ($_POST['email']);
        $password = $_POST['password'];
        if (!$this->checkLogin($email)){
            $errors['email'] = 'Veuillez renseigner une adresse email valide';
        }
        if (!$this->checkLogin($password)){
            $errors['password'] = 'Veuillez renseigner un mot de passe valide';
        }
        return $errors;
    }

    private function checkLogin($data): bool
    {
        return isset($data) && !empty(trim($data));
    }

    /**
     * @param User|null $user
     * @param mixed $password
     * @return bool
     */
    public function checkCredentials(?User $user, mixed $password): bool
    {
        return $user && password_verify($password, $user->getPassword());
    }

    public function setSessionUserId(User $user): void
    {
        $this->sessionService->setSessionUserId($user->getId());
    }
}