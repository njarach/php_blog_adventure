<?php

namespace src\Controller;

use Exception;

class ContactController extends AbstractController
{
    /**
     * @throws Exception
     */
    public function form()
    {
        echo $this->render('contact/contact.html.twig');
    }

}