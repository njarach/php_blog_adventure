<?php

namespace src\Service;


use src\Model\User;

class AuthenticationService
{
    private array $errors = [];
    private Session $session;
    private Request $request;

    public function __construct()
    {
        $this->session = new Session();
        $this->request = new Request();
    }

    /**
     * @return void
     */
    public function endSession(): void
    {
       $this->session->endSession();
    }

    /**
     * @return array
     */
    public function validateLoginData(): array
    {
        $errors = $this->errors;
        $email = $this->request->get('email') ?? '';
        $password = $this->request->get('password') ?? '';
        if (!$this->checkData($email)){
            $errors['email'] = 'Veuillez renseigner une adresse email valide.';
        }
        if (!$this->checkData($password)){
            $errors['password'] = 'Veuillez renseigner un mot de passe valide.';
        }
        return [$errors,$password,$email];
    }

    /**
     * @param mixed $data
     * @return bool
     */
    private function checkData(mixed $data): bool
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

    /**
     * @param User $user
     * @return void
     */
    public function setSessionUserId(User $user): void
    {
        $this->session->setSessionUserId($user->getId());
    }

    /**
     * @return array
     */
    public function validateRegisterData(): array
    {
        $errors = $this->errors;
        $username = trim($this->request->get('username'));
        $email = trim($this->request->get('email'));
        $password = $this->request->get('password');
        if (!$this->checkData($username)) {
            $errors['username'] = 'Veuillez renseigner un nom d\'utilisateur valide.';
        }
        if (!$this->checkData($email)) {
            $errors['email'] = 'Veuillez renseigner un email valide.';
        }
        if (!$this->checkData($password)) {
            $errors['password'] = 'Veuillez renseigner un mot de passe valide.';
        }
        return [$errors,$password,$email,$username];
    }

    /**
     * @param mixed $password
     * @return string
     */
    public function hashPassword(mixed $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}