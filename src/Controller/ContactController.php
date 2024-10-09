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
    public function send(): Response {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->sessionService->validateCsrfToken()) {
                throw new Exception("L'authentification CSRF a échoué.");
            }
            list($fullName,$email,$phone,$message) = $this->contactService->sanitizeContactForm();

            if (!$this->contactService->validateEmail($email)) {
                throw new Exception("Email invalide");
            }

            try {
                $this->contactService->sendEmail($fullName,$email,$phone,$message);
                return $this->render('home/contact_success.html.twig');
            } catch (Exception $e) {
                throw new  Exception("Message could not be sent. Mailer Error: $e");
            }
        }
        $this->sessionService->generateCsrfToken();
        return $this->render('home/home.html.twig',[
            'csrf_token'=>$_SESSION['csrf_token']
        ]);
    }

}