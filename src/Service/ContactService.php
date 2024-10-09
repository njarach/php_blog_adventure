<?php

namespace src\Service;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class ContactService
{
    private function sanitizeInput($data): string
    {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    public function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function sanitizeContactForm(): array
    {
        // TODO : peut être enlevé le 'full name' et mettre nom et prénom, évaluer si c'est bien du string, évaluer si le phone est bien 10 nombres
        $fullName = $this->sanitizeInput($_POST['fullname']);
        $email = $this->sanitizeInput($_POST['email']);
        $phone = $this->sanitizeInput($_POST['phone']);
        $message = $this->sanitizeInput($_POST['message']);
        return [$fullName,$email,$phone,$message];
    }

    /**
     * @param string $fullName
     * @param string $email
     * @param string $phone
     * @param string $message
     * @throws Exception
     */
    public function sendEmail(string $fullName, string $email, string $phone, string $message): void
    {
        $subject = "Nouveau message provenant de : $fullName";
        $body = "
            <h1>Nouveau message</h1>
            <p><strong>Nom:</strong> $fullName</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Téléphone:</strong> $phone</p>
            <p><strong>Message:</strong> $message</p>
        ";

        $password = '27b62f515e05b0';
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth   = true;
        $mail->Username   = '97032ba77b7dc6';
        $mail->Password   = $password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom($email, $fullName);
        $mail->addAddress('nicolas.jarach@hotmail.com');

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        $mail->send();
    }
}