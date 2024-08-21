<?php

namespace src\Controller;

use Exception;
use src\Service\AuthenticationService;

class AuthenticationController extends AbstractController
{
    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->authenticationService = new AuthenticationService();
    }

    /**
     * @throws Exception
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $user = $this->authenticationService->getUser($email);
            if ($user && password_verify($password, $user->getPassword())) {
                    $_SESSION['user_id'] = $user->getId();
                    $this->redirectToRoute('/php_blog_adventure/posts');
                    exit;
            } else {
                echo $this->render('/security/login.html.twig', [
                    'error' => 'La tentative de connexion a échoué'
                ]);
            }
        }
        echo $this->render('security/login.html.twig');
    }

    public function logout()
    {
//        here add logic to logout
    }

    /**
     * @throws Exception
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            if (isset($password) && !empty($password) && !empty($email) && !empty($username)){
                // Hash the password before storing
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $this->authenticationService->createUser($username,$email,$hashedPassword);
                $this->redirectToRoute('/php_blog_adventure/posts');
                exit;
            } else {
                echo $this->render('/security/register.html.twig', [
                    'error' => "La tentative d'enregistrement a échouée."
                ]);
            }
        }
        echo $this->render('security/register.html.twig');
    }

}