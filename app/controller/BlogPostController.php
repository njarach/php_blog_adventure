<?php
namespace controller;

use src\Controller;

class BlogPostController extends Controller
{
    // This controller handles BlogPost related actions. It also needs to handle the CRUD for BlogPosts (maybe before adding an Admin section if more cruds and admin actions are needed) with admin verification.
    public function index():array {
        $blogPosts = array();
        $blogPosts[1]=['Titre1','Contenu du blog post','Auteur du post','Catégorie du post'];
        $blogPosts[2]=['Titre2','Contenu du blog post','Auteur du post','Catégorie du post'];
        $blogPosts[3]=['Titre3','Contenu du blog post','Auteur du post','Catégorie du post'];
        $blogPosts[4]=['Titre4','Contenu du blog post','Auteur du post','Catégorie du post'];
//        // Retrieves the posts from the database
//        $query = $this->pdo->query("SELECT * FROM posts");
//        $post = $query->fetchAll(PDO::FETCH_ASSOC);
//        // Render the view ?
//        include_once '../view/post/index.php';
        return $blogPosts;
    }
    public function show($postId) {
        $blogPosts = array();
        $blogPosts[1]=['Titre1','Contenu du blog post','Auteur du post','Catégorie du post'];
        $blogPosts[2]=['Titre1','Contenu du blog post','Auteur du post','Catégorie du post'];
        $blogPosts[3]=['Titre1','Contenu du blog post','Auteur du post','Catégorie du post'];
        $blogPosts[4]=['Titre1','Contenu du blog post','Auteur du post','Catégorie du post'];
        return $blogPosts[$postId];
//        // Retrieves the posts from the database
//        $query = $this->pdo->prepare("SELECT * FROM posts WHERE id = ?");
//        $query->execute([$postId]);
//        $post = $query->fetch(PDO::FETCH_ASSOC);
//
//        // Fetch comments for the post
//        $commentQuery = $this->pdo->prepare("SELECT * FROM comments WHERE post_id = ?");
//        $commentQuery->execute([$postId]);
//        $comments = $commentQuery->fetchAll(PDO::FETCH_ASSOC);
//
//        // Render the view
//        include_once '../view/post/show.php';
    }
}