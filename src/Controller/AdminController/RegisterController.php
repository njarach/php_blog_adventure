<?php

namespace src\Controller\AdminController;

use Exception;
use src\Controller\AbstractController;
use src\Service\Manager\UserManager;

class RegisterController extends AbstractController
{
    private UserManager $userManager;

    public function __construct()
    {
        $this->userManager = new UserManager();
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
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $this->userManager->createUser($username,$email,$hashedPassword);
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