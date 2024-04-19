<?php
namespace src\controller;

class BlogPostController extends Controller
{

    public function index() {
        $blogPosts = array();
        $blogPosts[1]=['title'=>'Titre1','content'=>"contenu de l'article",'author'=>"auteur de l'article",'category'=>"catégorie de l'article"];
        $blogPosts[2]=['title'=>'Titre2','content'=>"contenu de l'article",'author'=>"auteur de l'article",'category'=>"catégorie de l'article"];
        $blogPosts[3]=['title'=>'Titre3','content'=>"contenu de l'article",'author'=>"auteur de l'article",'category'=>"catégorie de l'article"];
        $blogPosts[4]=['title'=>'Titre4','content'=>"contenu de l'article",'author'=>"auteur de l'article",'category'=>"catégorie de l'article"];
       echo $this->render('blogpost/index.html.twig', [
           'posts'=>$blogPosts
       ]);
    }
    public function show($postId) {
        $blogPosts = array();
        $blogPosts[1]=['title'=>'Titre1','content'=>"contenu de l'article",'author'=>"auteur de l'article",'category'=>"catégorie de l'article"];
        $blogPosts[2]=['title'=>'Titre2','content'=>"contenu de l'article",'author'=>"auteur de l'article",'category'=>"catégorie de l'article"];
        $blogPosts[3]=['title'=>'Titre3','content'=>"contenu de l'article",'author'=>"auteur de l'article",'category'=>"catégorie de l'article"];
        $blogPosts[4]=['title'=>'Titre4','content'=>"contenu de l'article",'author'=>"auteur de l'article",'category'=>"catégorie de l'article"];
        $blogPost = $blogPosts[$postId];
        echo $this->render('blogpost/show.html.twig', [
            'post'=>$blogPost
        ]);
    }
}