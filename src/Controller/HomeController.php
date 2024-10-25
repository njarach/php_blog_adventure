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
        $this->getSessionService()->generateCsrfToken();
        $latestPost = $this->postManager->findLatestPost();
        return $this->render('home/home.html.twig',[
            'latestPost'=>$latestPost,
            'csrf_token'=>$this->getSessionService()->getCsrfToken()
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
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        } else {
            throw new Exception("The requested file does not exist.");
        }
    }
}