<?php

namespace src\controller;

use Exception;

class ErrorController extends AbstractController
{
    public function show(Exception $exception, $error_response_code){
        echo $this->render('error/error.html.twig', [
            'exception'=>$exception->getMessage(),
            'error_response_code'=>$error_response_code
        ]);
    }

}