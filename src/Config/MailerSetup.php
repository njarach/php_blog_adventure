<?php

namespace src\Config;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class MailerSetup
{
    /**
     * @throws Exception
     */
    public static function configureMailer(): PHPMailer
    {
        $mail = new PHPMailer(true);

        try {
            //TODO Configuration SMTP, pas de 'define', voir pour utiliser du .env à l'avenir
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '97032ba77b7dc6';
            $mail->Password = '27b62f515e05b0';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configuration par défaut
            $mail->setFrom('email@example.com', 'Nom complet');
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            return $mail;
        } catch (Exception $e) {
            throw new Exception("Erreur dans la configuration du mailer: " . $e->getMessage());
        }
    }

}