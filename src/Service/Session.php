<?php

namespace src\Service;

use Exception;

class Session
{
    private array $session;
    private Request $request;

    public function __construct()
    {
        $this->startSession();
        $this->session = &$_SESSION;
        $this->request = new Request();
    }

    /**
     * If no session exists, starts a new session.
     * @return void
     */
    public function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Retrieves the user ID from the session, if set.
     * @return int|null
     */
    public function getSessionUserId(): ?int
    {
        if (isset($this->session['user_id'])) {
            return $this->session['user_id'];
        }
        return null;
    }

    /**
     * Sets the user ID in the session.
     * @param int $userId
     * @return void
     */
    public function setSessionUserId(int $userId): void
    {
        $this->session['user_id'] = $userId;
    }

    public function endSession(): void
    {
        session_unset();
        session_destroy();
    }

    /**
     * Compares the current session's csrf token to the one found in the request sent. Returns true if matches, else false.
     * @return bool
     */
    public function validateCsrfToken(): bool
    {
        $sessionToken = $this->session['csrf_token'] ?? null;
        $requestToken = $this->request->get('csrf_token');

        return $sessionToken && hash_equals($sessionToken, $requestToken);
    }

    /**
     * @throws Exception
     */
    public function generateCsrfToken(): string
    {
        if (!isset($this->session['csrf_token'])) {
            try {
                return $this->session['csrf_token'] = bin2hex(random_bytes(32));
            } catch (Exception $e) {
                throw new Exception("La génération d'un token aléatoire a rencontré une erreur.");
            }
        }
        return $this->session['csrf_token'];
    }

    /**
     * Retrieves the CSRF token from the session, generating one if it doesn't exist.
     * @return string
     * @throws Exception
     */
    public function getCsrfToken(): string
    {
        return $this->session['csrf_token'] ?? $this->generateCsrfToken();
    }
}