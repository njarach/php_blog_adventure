<?php

namespace src\Controller\AdminController;

use Exception;
use src\Service\Response;

class AdminDashboardController extends \src\Controller\AbstractController
{
    /**
     * @throws Exception
     */
    public function dashboard():Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

}