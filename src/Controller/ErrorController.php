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
    public function error404(string $errorCode): Response
    {
        http_response_code(404);
        try {
            return $this->render('error/error.html.twig', [
                'errorCode' => $errorCode,
                'errorMessage' => "La page que vous recherchez n'existe pas."
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function error500(string $errorCode, Exception $exception): Response
    {
        http_response_code(500);
        try {
            return $this->render('error/error.html.twig', [
                'errorCode' => $errorCode,
                'errorMessage' => $exception->getMessage()
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}