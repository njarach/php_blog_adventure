<?php

namespace src\Controller\AdminController;

use Exception;
use src\controller\AbstractController;
use src\Service\Manager\CommentManager;
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
    public function index()
    {
        $blogPosts = $this->postManager->findAll();
        echo $this->render('admin/blogposts_list.html.twig', [
            'posts'=>$blogPosts
        ]);
    }

    /**
     * @throws Exception
     */
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->postManager->validatePostData($_POST);
            if (empty($errors)) {
                $this->postManager->createPost($_POST['title'], $_POST['content'], $_POST['category_id'], $this->getCurrentUser()->getId(), $_POST['intro']);
                $this->redirectToRoute("/php_blog_adventure/posts");
            } else {
                $categories = $this->postManager->getAllCategories();
                echo $this->render('blogpost/new.html.twig', [
                    'categories' => $categories,
                    'errors' => $errors,
                    'formData' => $_POST
                ]);
            }
        } else {
//            Categories are not required so they will not be refactored yet.
            $categories = $this->postManager->getAllCategories();
            echo $this->render('blogpost/new.html.twig', [
                'categories' => $categories
            ]);
        }
    }

    /**
     * @throws Exception
     */
    public function edit(int $postId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->postManager->validatePostData($_POST);
            if (empty($errors)) {
                $this->postManager->edit($postId, $_POST['title'], $_POST['content'], $_POST['category_id'], $_POST['intro']);
                $this->redirectToRoute("/php_blog_adventure/admin/posts");
            } else {
                $categories = $this->postManager->getAllCategories();
                $post = $this->postManager->findById($postId);
                echo $this->render('blogpost/edit.html.twig', [
                    'post' => $post,
                    'categories' => $categories,
                    'errors' => $errors,
                    'formData' => $_POST
                ]);
            }
        } else {
            $categories = $this->postManager->getAllCategories();
            $post = $this->postManager->findById($postId);
            echo $this->render('blogpost/edit.html.twig', [
                'post' => $post,
                'categories' => $categories
            ]);
        }
    }

    /**
     * @throws Exception
     */
    public function delete(int $postId)
    {
        $post = $this->postManager->findById($postId);
        $this->postManager->delete($post);
        $this->redirectToRoute("/php_blog_adventure/admin/posts");
    }
}