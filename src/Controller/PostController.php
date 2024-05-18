<?php
namespace src\controller;

use src\Repository\PostRepository;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class PostController extends AbstractController
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index() {
        $blogPostRepository = new PostRepository();
        $blogPosts = $blogPostRepository->findAll();
       echo $this->render('blogpost/index.html.twig', [
           'posts'=>$blogPosts
       ]);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function show($postId) {
        $blogPostRepository = new PostRepository();
        $blogPost = $blogPostRepository->findById($postId);
        if ($blogPost) {
            echo $this->render('blogpost/show.html.twig', [
                'post' => $blogPost
            ]);
        } else {
            echo "Aucun billet ne comporte l'id $postId";
        }
    }
}