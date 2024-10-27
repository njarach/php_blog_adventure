<?php

namespace src\Controller;

use Exception;
use src\Service\ContactService;
use src\Service\Response;

class ContactController extends AbstractController
{
    private ContactService $contactService;
    public function __construct()
    {
        $this->contactService = new ContactService();
    }

    /**
     * @throws Exception
     */
    public function send(): Response {
        if ($this->request()->getRequestMethod() === 'POST') {
            $this->contactService->validateCsrfToken();
            list($firstname,$lastname,$email,$phone,$message) = $this->contactService->sanitizeContactForm();
            $this->contactService->validateContactForm($firstname, $lastname, $email, $phone);
            try {
                $this->contactService->sendEmail($firstname,$lastname,$email,$phone,$message);
                return $this->render('home/contact_success.html.twig');
            } catch (Exception $e) {
                throw new  Exception("Votre demande de contact a rencontré une erreur et n'a pas pu aboutir. Veuillez réessayer ultérieurement.");
            }
        }
        return $this->render('home/home.html.twig',[
            'csrf_token'=>$this->session()->getCsrfToken()
        ]);
    }

}