<?php
namespace src\controller;

use Exception;
use src\Repository\PostRepository;

class PostController extends AbstractController
{
    /**
     * @throws Exception
     */
    public function index() {
        $blogPostRepository = new PostRepository();
        $blogPosts = $blogPostRepository->findAll();
       echo $this->render('blogpost/index.html.twig', [
           'posts'=>$blogPosts
       ]);
    }

    /**
     * @throws Exception
     */
    public function show(int $postId) {
        $blogPostRepository = new PostRepository();
        $blogPost = $blogPostRepository->findById($postId);
        if ($blogPost) {
            echo $this->render('blogpost/show.html.twig', [
                'post' => $blogPost
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