<?php

namespace src\Controller;

use Exception;
use src\Service\AuthenticationService;
use src\Service\Manager\UserManager;

class AuthenticationController extends AbstractController
{
    private AuthenticationService $authenticationService;
    private UserManager $userManager;

    public function __construct()
    {
        $this->authenticationService = new AuthenticationService();
        $this->userManager = new UserManager();
    }

    /**
     * @throws Exception
     */
    public function login(string $authenticationError = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $user = $this->userManager->getUser(['email'=>$email]);
            if ($user && password_verify($password,$user->getPassword())) {
                    $_SESSION['user_id'] = $user->getId();
                    $this->redirectToRoute('/php_blog_adventure/posts');
                    exit;
            } else {
                echo $this->render('/security/login.html.twig', [
                    'error' => 'La tentative de connexion a échoué',
                    'authenticationError'=>$authenticationError
                ]);
            }
        }
        echo $this->render('security/login.html.twig');
    }

    public function logout()
    {
        $this->authenticationService->endSession();
        $this->redirectToRoute('/php_blog_adventure/login');
    }
}