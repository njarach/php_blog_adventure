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
        $postRepository = new PostRepository();
        $blogPosts = $postRepository->findAll();
       echo $this->render('blogpost/index.html.twig', [
           'posts'=>$blogPosts
       ]);
    }

    /**
     * @throws Exception
     */
    public function show(int $postId) {
        $postRepository = new PostRepository();
        $blogPost =$postRepository->findById($postId);
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