<?php

namespace src\Service;

use Exception;

class SessionService
{

    /**
     * @return void
     */
    public function startSession(): void
    {
        session_start();
    }

    /**
     * @param int $userId
     * @return void
     */
    public function setSessionUserId(int $userId): void
    {
        $_SESSION['user_id'] = $userId ;
    }

    /**
     * @return int
     */
    public function getSessionUserId(): int
    {
        return $_SESSION['user_id'];
    }

    public function endSession(): void
    {
        session_unset();
        session_destroy();
    }

    /**
     * @return bool
     */
    public function validateCsrfToken(): bool
    {
        if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) return false;
        return true;
    }

    /**
     * @throws Exception
     */
    public function generateCsrfToken(): void
    {
        if (!isset($_SESSION['csrf_token'])) {
            try {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            } catch (Exception $e) {
                throw new Exception("La génération d'un token aléatoire a rencontré une erreur");
            }
        }
    }

    /**
     * @return string|null
     */
    public function getCsrfToken(): ?string
    {
        if (!isset($_SESSION['csrf_token'])) {
            return $_SESSION['csrf_token'];
        }
        return null;
    }
}