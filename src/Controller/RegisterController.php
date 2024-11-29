<?php

namespace src\Controller;

use Exception;
use src\Service\AuthenticationService;
use src\Service\Manager\UserManager;
use src\Service\Response;

class RegisterController extends AbstractController
{
    private UserManager $userManager;
    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->userManager = new UserManager();
        $this->authenticationService = new AuthenticationService();

    }

    /**
     * @throws Exception
     */
    public function register(): Response
    {
        if ($this->request()->getRequestMethod() == 'POST') {
            list($errors,$password,$email,$username) = $this->authenticationService->validateRegisterData();
            if (empty($errors)){
                try {
                    $hashedPassword = $this->authenticationService->hashPassword($password);
                    $this->userManager->createUser($username, $email, $hashedPassword);
                } catch (Exception $e) {
                    return $this->render('security/register.html.twig',[
                        'registerError'=>'L\'enregistrement a échoué. Veuillez réessayer ou contacter un administrateur si le problème persiste.'
                    ]);
                }
                return $this->redirect('/php_blog_adventure/login');
            } else {
                return $this->render('/security/register.html.twig', [
                    'errors' => $errors
                ]);
            }
        }
        return $this->render('security/register.html.twig');
    }

}