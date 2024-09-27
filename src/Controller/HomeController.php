<?php

namespace src\Controller;

use Exception;
use src\Service\Manager\PostManager;
use src\Service\Response;

class HomeController extends AbstractController
{
    private PostManager $postManager;
    public function __construct()
    {
        $this->postManager = new PostManager();
    }

    /**
     * @throws Exception
     */
    public function home(): Response
    {
        $latestPost = $this->postManager->findLatestPost();
        return $this->render('home/home.html.twig',[
            'latestPost'=>$latestPost
        ]);
    }
}