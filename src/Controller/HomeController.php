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
            'latestPost'=>$latestPost,
            'csrf_token'=>$this->session()->getCsrfToken()
        ]);
    }

    /**
     * @throws Exception
     */
    public function downloadCv()
    {
        $file = 'assets/cv/JarachNicolasCV.pdf';

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Content-Length: ' . filesize($file));
            readfile($file);
        } else {
            throw new Exception("Le fichier que vous recherchez n'existe pas.");
        }
    }
}