<?php

namespace src\Controller;

use Exception;
use src\Service\Response;

class ContactController extends AbstractController
{
    /**
     * @throws Exception
     */
    public function form(): Response
    {
        return $this->render('contact/contact.html.twig');
    }

}