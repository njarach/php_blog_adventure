<?php
namespace src\controller;

use src\Repository\BlogPostRepository;

class BlogPostController extends Controller
{
    public function index() {
        $blogPostRepository = new BlogPostRepository();
        $blogPosts = $blogPostRepository->findAll();
       echo $this->render('blogpost/index.html.twig', [
           'posts'=>$blogPosts
       ]);
    }
    public function show($postId) {
        $blogPostRepository = new BlogPostRepository();
        $blogPost = $blogPostRepository->findById($postId);
        echo $this->render('blogpost/show.html.twig', [
            'post'=>$blogPost
        ]);
    }
}