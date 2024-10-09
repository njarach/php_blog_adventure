<?php

namespace src\Controller;

use Exception;
use src\Service\Manager\PostManager;
use src\Service\Response;
use src\Service\SessionService;

class HomeController extends AbstractController
{
    private PostManager $postManager;
    private SessionService $sessionService;
    public function __construct()
    {
        $this->postManager = new PostManager();
        $this->sessionService = new SessionService();
    }

    /**
     * @throws Exception
     */
    public function home(): Response
    {
        $this->sessionService->generateCsrfToken();
        $latestPost = $this->postManager->findLatestPost();
        return $this->render('home/home.html.twig',[
            'latestPost'=>$latestPost,
            'csrf_token'=>$_SESSION['csrf_token']
        ]);
    }
}