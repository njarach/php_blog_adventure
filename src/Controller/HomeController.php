<?php

namespace src\Controller;

use Exception;

class HomeController extends AbstractController
{
    /**
     * @throws Exception
     */
    public function home(){
        echo $this->render('home/home.html.twig');
    }
}