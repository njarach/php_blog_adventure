<?php

namespace src\Service;

use PHPMailer\PHPMailer\Exception;
use src\Config\MailerSetup;

class ContactService
{
    private Request $request;
    public function __construct()
    {
        $this->request = new Request();
    }

    /**
     * @param mixed $data
     * @return string
     */
    private function sanitizeInput(mixed $data): string
    {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    /**
     * @param string $email
     * @return mixed
     */
    public function validateEmail(string $email): mixed
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @return string[]
     */
    public function sanitizeContactForm(): array
    {
        $firstname = $this->sanitizeInput($this->request->get('firstname'));
        $lastname = $this->sanitizeInput($this->request->get('lastname'));
        $email = $this->sanitizeInput($this->request->get('email'));
        $phone = $this->sanitizeInput($this->request->get('phone'));
        $message = $this->sanitizeInput($this->request->get('message'));
        return [$firstname,$lastname,$email,$phone,$message];
    }

    /**
     * @throws Exception
     */
    public function validateContactForm(string $firstname, string $lastname, string $email, string $phone): void
    {
        if (preg_match('/\d/', $lastname)) {
            throw new Exception("Le nom ne doit pas contenir de chiffres.");
        }
        if (preg_match('/\d/', $firstname)) {
            throw new Exception("Le prénom ne doit pas contenir de chiffres.");
        }
        if (!preg_match('/^[\d\s\-+]+$/', $phone)) {
            throw new Exception("Le numéro de téléphone n'est pas valide et ne peut pas contenir de caractères alphabétiques.");
        }
        if (!$this->validateEmail($email)) {
            throw new Exception("Email invalide.");
        }
    }

    /**
     * @param string $firstname
     * @param string $lastname
     * @param string $email
     * @param string $phone
     * @param string $message
     * @throws Exception PHPMailer Exception handler.
     * @throws \Exception
     */
    public function sendEmail(string $firstname, string $lastname, string $email, string $phone, string $message): void
    {
        $subject = "Nouveau message provenant de : $firstname $lastname";
        $body = "
            <h1>Nouveau message</h1>
            <p><strong>Nom:</strong> $firstname $lastname</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Téléphone:</strong> $phone</p>
            <p><strong>Message:</strong> $message</p>
        ";

        $mail = MailerSetup::configureMailer();

        try {
            $mail->addAddress('nicolas.jarach@hotmail.com');
            $mail->addReplyTo($email, "$firstname $lastname");
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->send();
        } catch (Exception $e) {
            throw new Exception("L'envoi du mail a échoué: " . $e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function validateCsrfToken(): void
    {
        $sessionService = new Session();
        if (!$sessionService->validateCsrfToken()) {
            throw new Exception("L'authentification CSRF a échoué.");
        }
    }
}