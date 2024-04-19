<?php

namespace src\controller;

class ErrorController extends Controller
{
    public function show(){
        echo $this->render('error/error404.html.twig');
    }

}