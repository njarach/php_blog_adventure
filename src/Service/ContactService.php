<?php

namespace src\Service;

class ContactService
{
    public function sanitizeInput($data): string
    {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    public function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}