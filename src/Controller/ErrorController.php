<?php

namespace src\Controller;

use Exception;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ErrorController extends AbstractController
{
    /**
     * @throws Exception
     */
    public function error404(string $errorCode)
    {
        http_response_code(404);
        try {
            echo $this->render('error/error.html.twig', [
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
    public function error500(string $errorCode, Exception $exception)
    {
        http_response_code(500);
        try {
            echo $this->render('error/error.html.twig', [
                'errorCode' => $errorCode,
                'errorMessage' => $exception->getMessage()
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}