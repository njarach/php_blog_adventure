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
            list($errors, $password, $email) = $this->authenticationService->validateLoginData();
            if (empty($errors)){
                $user = $this->userManager->getUser(['email'=>$email]);
                if ($this->authenticationService->checkCredentials($user, $password)) {
                    $this->authenticationService->setSessionUserId($user);
                    $this->redirectToRoute('/php_blog_adventure/posts');
                    exit;
                } else {
                    echo $this->render('/security/login.html.twig', [
                        'error' => 'La tentative de connexion a échoué',
                        'authenticationError'=>$authenticationError,
                        'errors'=>$errors
                    ]);
                }
            }
        }
        echo $this->render('security/login.html.twig',[
        ]);
    }

    public function logout()
    {
        $this->authenticationService->endSession();
        $this->redirectToRoute('/php_blog_adventure/login');
    }
}