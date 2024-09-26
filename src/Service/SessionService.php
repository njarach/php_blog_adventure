<?php

namespace src\Service;

class SessionService
{

    public function startSession(): void
    {
        session_start();
    }
    public function setSessionUserId(int $userId): void
    {
        $_SESSION['user_id'] = $userId ;
    }

    public function endSession(): void
    {
        session_unset();
        session_destroy();
    }
}