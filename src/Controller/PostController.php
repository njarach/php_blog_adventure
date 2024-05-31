<?php
namespace src\controller;

use Exception;
use src\Repository\PostRepository;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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
    public function show($postId) {
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

    /**
     * @throws Exception
     * This was written to test the findBy criteria method from repository. Will implement later
     */
    public function showSpecial()
    {
        $blogPostRepository = new PostRepository();
        $blogPosts = $blogPostRepository->findBy(['id'=>5]);
        if ($blogPosts) {
            echo $this->render('blogpost/index.html.twig', [
                'posts' => $blogPosts
            ]);
        } else {
            http_response_code(404);
            echo $this->render('error/error.html.twig', [
                'errorCode'=>404,
                'errorMessage'=>"Aucun article trouvé pour ce critère."
            ]);
        }
    }
}