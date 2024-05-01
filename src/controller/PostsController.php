<?php
namespace src\controller;

use src\Repository\PostRepository;

class PostsController extends AbstractController
{
    public function index() {
        $blogPostRepository = new PostRepository();
        $blogPosts = $blogPostRepository->findAll();
       echo $this->render('blogpost/index.html.twig', [
           'posts'=>$blogPosts
       ]);
    }
    public function show($postId) {
        $blogPostRepository = new PostRepository();
        $blogPost = $blogPostRepository->findById($postId);
        echo $this->render('blogpost/show.html.twig', [
            'post'=>$blogPost
        ]);
    }
}