<?php

namespace src\Controller;

use Exception;
use src\Service\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ErrorController extends AbstractController
{
    /**
     * @throws Exception
     */
    public function renderError(int $errorCode, Exception $exception = null): Response {
        $message = 'An unexpected error occurred.';
        if ($exception) {
            $message = $exception->getMessage();
        }
        return $this->render('error/error.html.twig', [
            'errorCode' => $errorCode,
            'message'   => $message,
        ]);
    }
}