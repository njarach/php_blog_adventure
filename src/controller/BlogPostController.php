<?php
namespace src\controller;

require 'vendor/autoload.php';
class BlogPostController extends Controller
{
    public function index() {
        $loader = new \Twig\Loader\FilesystemLoader('templates');
        $twig = new \Twig\Environment($loader, [
             'cache' => 'cache',
        ]);
        $blogPosts = array();
        $blogPosts[1]=['title'=>'Titre1','content'=>"contenu de l'article",'author'=>"auteur de l'article",'category'=>"catégorie de l'article"];
        $blogPosts[2]=['title'=>'Titre2','content'=>"contenu de l'article",'author'=>"auteur de l'article",'category'=>"catégorie de l'article"];
        $blogPosts[3]=['title'=>'Titre3','content'=>"contenu de l'article",'author'=>"auteur de l'article",'category'=>"catégorie de l'article"];
        $blogPosts[4]=['title'=>'Titre4','content'=>"contenu de l'article",'author'=>"auteur de l'article",'category'=>"catégorie de l'article"];

        echo $twig->render('blogpost/index.html.twig',[
            'posts'=>$blogPosts
        ]);
    }
    public function show($postId) {
        $loader = new \Twig\Loader\FilesystemLoader('templates');
        $twig = new \Twig\Environment($loader, [
             'cache' => 'cache',
        ]);
        $blogPosts = array();
        $blogPosts[1]=['title'=>'Titre1','content'=>"contenu de l'article",'author'=>"auteur de l'article",'category'=>"catégorie de l'article"];
        $blogPosts[2]=['title'=>'Titre2','content'=>"contenu de l'article",'author'=>"auteur de l'article",'category'=>"catégorie de l'article"];
        $blogPosts[3]=['title'=>'Titre3','content'=>"contenu de l'article",'author'=>"auteur de l'article",'category'=>"catégorie de l'article"];
        $blogPosts[4]=['title'=>'Titre4','content'=>"contenu de l'article",'author'=>"auteur de l'article",'category'=>"catégorie de l'article"];
        $blogPost = $blogPosts[$postId];
        echo $twig->render('blogpost/show.html.twig', [
            'post'=>$blogPost
        ]);
    }
}