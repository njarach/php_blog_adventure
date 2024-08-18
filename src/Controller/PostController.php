<?php
namespace src\Controller;

use Exception;
use src\Service\Manager\PostManager;

class PostController extends AbstractController
{
    private PostManager $postManager;


    public function __construct()
    {
        $this->postManager = new PostManager();
    }

    /**
     * @throws Exception
     */
    public function index() {
        $blogPosts = $this->postManager->findAll();
       echo $this->render('blogpost/index.html.twig', [
           'posts'=>$blogPosts
       ]);
    }

    /**
     * @throws Exception
     */
    public function show(int $postId) {
        $blogPost = $this->postManager->findOneBy(['id'=>$postId]);
        if ($blogPost) {
            echo $this->render('blogpost/show.html.twig', [
                'post' => $blogPost,
            ]);
        } else {
            http_response_code(404);
            echo $this->render('error/error.html.twig', [
                'errorCode'=>404,
                'errorMessage'=>"Aucun article trouvé pour l'id $postId..."
            ]);
        }
    }
}