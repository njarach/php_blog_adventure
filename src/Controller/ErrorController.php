<?php

namespace src\controller;

use Exception;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ErrorController extends AbstractController
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function error404(string $errorCode)
    {
        http_response_code(404);
        echo $this->render('error/error.html.twig',[
            'errorCode'=>$errorCode,
            'errorMessage'=>"La page que vous recherchez n'existe pas."
        ]);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function error500(string $errorCode, Exception $exception)
    {
        http_response_code(500);
        echo $this->render('error/error.html.twig',[
            'errorCode'=>$errorCode,
            'errorMessage'=>$exception->getMessage()
        ]);
    }
}