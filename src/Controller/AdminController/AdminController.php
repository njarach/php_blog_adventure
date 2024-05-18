<?php

namespace src\controller\AdminController;

use src\controller\AbstractController;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class AdminController extends AbstractController
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function dashboard()
    {
        echo $this->render('admin/dashboard.html.twig');
    }


}