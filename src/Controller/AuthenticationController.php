<?php

namespace src\Controller;

use Exception;
use src\Service\AuthenticationService;
use src\Service\Manager\UserManager;
use src\Service\Response;

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
    public function login(): Response
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            list($errors, $password, $email) = $this->authenticationService->validateLoginData();
            if (empty($errors)){
                $user = $this->userManager->getUser(['email'=>$email]);
                if ($this->authenticationService->checkCredentials($user, $password)) {
                    $this->authenticationService->setSessionUserId($user);
                    return $this->redirectToRoute('/php_blog_adventure/posts');
                } else {
                    return $this->render('/security/login.html.twig', [
                        'authenticationError'=>"Email ou mot de passe invalide.",
                    ]);
                }
            } else {
                // This is probably clumsy, form validation is also set up in template ?
                return $this->render('/security/login.html.twig', [
                    'errors'=>$errors,
                ]);
            }
        }
        return $this->render('security/login.html.twig',[
        ]);
    }

    public function logout(): Response
    {
        $this->authenticationService->endSession();
        return $this->redirectToRoute('/php_blog_adventure/login');
    }
}