<?php

namespace src\Controller;

use Exception;
use src\Service\Response;

class HomeController extends AbstractController
{
    /**
     * @throws Exception
     */
    public function home(): Response
    {
        return $this->render('home/home.html.twig');
    }
}