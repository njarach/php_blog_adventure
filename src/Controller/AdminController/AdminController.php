<?php

namespace src\controller\AdminController;

use Exception;
use src\controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @throws Exception
     */
    public function dashboard()
    {
        // check role and authorization in service ?
        echo $this->render('admin/dashboard.html.twig');
    }


}