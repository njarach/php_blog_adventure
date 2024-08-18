<?php

namespace src\Controller\AdminController;

use Exception;
use src\controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @throws Exception
     */
    public function dashboard()
    {
        // check role and authorization in service ? Dashboard is not a required feature, maybe add this later ?
        echo $this->render('admin/dashboard.html.twig');
    }


}