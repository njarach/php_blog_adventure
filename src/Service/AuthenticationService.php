<?php

namespace src\Service;


use src\Model\User;

class AuthenticationService
{
    private array $errors = [];
    private SessionService $sessionService;
    private RequestService $requestService;

    public function __construct()
    {
        $this->sessionService = new SessionService();
        $this->requestService = new RequestService();
    }

    public function endSession(): void
    {
       $this->sessionService->endSession();
    }

    public function validateLoginData(): array
    {
        $errors = $this->errors;
        $email = $this->requestService->getPostData('email') ?? '';
        $password = $this->requestService->getPostData('password') ?? '';
        if (!$this->checkData($email)){
            $errors['email'] = 'Veuillez renseigner une adresse email valide.';
        }
        if (!$this->checkData($password)){
            $errors['password'] = 'Veuillez renseigner un mot de passe valide.';
        }
        return [$errors,$password,$email];
    }

    private function checkData($data): bool
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

    /**
     * @return array
     */
    public function validateRegisterData(): array
    {
        $errors = $this->errors;
        $username = trim($this->requestService->getPostData('username'));
        $email = trim($this->requestService->getPostData('email'));
        $password = $this->requestService->getPostData('password');
        if (!$this->checkData($username)) {
            $errors['username'] = 'Veuillez renseigner un nom d\'utilisateur valide.';
        }
        if (!$this->checkData($email)) {
            $errors['email'] = 'Veuillez renseigner un email valide.';
        }
        if (!$this->checkData($password)) {
            $errors['password'] = 'Veuillez renseigner un mot de passe valide.';
        }
        return [$errors,$username,$email,$password];
    }

    public function hashPassword(mixed $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}