<?php

namespace src\Controller;

use Exception;
use src\Service\ContactService;
use src\Service\Response;
use src\Service\SessionService;

class ContactController extends AbstractController
{
    private ContactService $contactService;
    private SessionService $sessionService;
    public function __construct()
    {
        $this->contactService = new ContactService();
        $this->sessionService = new SessionService();
    }

    /**
     * @throws Exception
     */
    public function form(): Response {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->sessionService->validateCsrfToken()) {
                throw new Exception("L'authentification CSRF a échoué.");
            }
            $fullname = $this->contactService->sanitizeInput($_POST['fullname']);
            $email = $this->contactService->sanitizeInput($_POST['email']);
            $phone = $this->contactService->sanitizeInput($_POST['phone']);
            $message = $this->contactService->sanitizeInput($_POST['message']);

            if (!$this->contactService->validateEmail($email)) {
                throw new Exception("Email invalide");
            }
        }
        $this->sessionService->generateCsrfToken();
        return $this->render('contact/_contact_form.html.twig',[
            'csrf_token'=>$_SESSION['csrf_token']
        ]);
    }

}