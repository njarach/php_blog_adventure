<?php

namespace src\Controller;

use src\Service\AuthenticationService;

class AuthenticationController extends AbstractController
{
    private AuthenticationService $authenticationService;
    public function __construct()
    {
        $this->authenticationService = new AuthenticationService();
    }

    public function login(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $email = trim($_POST['email']);
            $password = $_POST['password'];
        }

        // Process the data sent to get the user
    }

    public function logout(){
//        here add logic to logout
    }

    public function register(){
//        here add logic so user can register
    }

}