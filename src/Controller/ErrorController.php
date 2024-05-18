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
    public function show(Exception $exception, $error_response_code)
    {
        echo $this->render('error/error.html.twig', [
            'exception'=>$exception->getMessage(),
            'error_response_code'=>$error_response_code
        ]);
    }

}