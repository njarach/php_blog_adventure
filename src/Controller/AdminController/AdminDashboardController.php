<?php

namespace src\Controller\AdminController;

use Exception;
use src\Controller\AbstractController;
use src\Service\Response;

class AdminDashboardController extends AbstractController
{
    /**
     * @throws Exception
     */
    public function dashboard():Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

}