<?php

namespace src\Service;

use src\Service\Manager\UserManager;

class AuthenticationService
{
    public function endSession(): void
    {
        session_unset();
        session_destroy();
    }

}