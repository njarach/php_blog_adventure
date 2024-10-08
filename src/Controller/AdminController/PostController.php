<?php

namespace src\Controller\AdminController;

use Exception;
use src\controller\AbstractController;
use src\Service\Manager\CommentManager;
use src\Service\Manager\PostManager;
use src\Service\Response;

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
    public function index(): Response
    {
        $blogPosts = $this->postManager->findAll();
        return $this->render('admin/blogposts_list.html.twig', [
            'posts' => $blogPosts
        ]);
    }

    /**
     * @throws Exception
     */
    public function create(): Response
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->postManager->validatePostData($_POST);
            if (empty($errors)) {
                $this->postManager->createPost($_POST['title'], $_POST['content'], $_POST['category_id'], $this->getCurrentUser()->getId(), $_POST['intro']);
                return $this->redirect("/php_blog_adventure/posts");
            } else {
                $categories = $this->postManager->getAllCategories();
                return $this->render('blogpost/new.html.twig', [
                    'categories' => $categories,
                    'errors' => $errors,
                    'formData' => $_POST
                ]);
            }
        } else {
//            Categories are not required so they will not be refactored yet.
            $categories = $this->postManager->getAllCategories();
            return $this->render('blogpost/new.html.twig', [
                'categories' => $categories
            ]);
        }
    }

    /**
     * @throws Exception
     */
    public function edit(int $postId): Response
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->postManager->validatePostData($_POST);
            if (empty($errors)) {
                $this->postManager->edit($postId, $_POST['title'], $_POST['content'], $_POST['category_id'], $_POST['intro']);
                return $this->redirect("/php_blog_adventure/admin/posts");
            } else {
                $categories = $this->postManager->getAllCategories();
                $post = $this->postManager->findById($postId);
                return $this->render('blogpost/edit.html.twig', [
                    'post' => $post,
                    'categories' => $categories,
                    'errors' => $errors,
                    'formData' => $_POST
                ]);
            }
        } else {
            $categories = $this->postManager->getAllCategories();
            $post = $this->postManager->findById($postId);
            return $this->render('blogpost/edit.html.twig', [
                'post' => $post,
                'categories' => $categories
            ]);
        }
    }

    /**
     * @throws Exception
     */
    public function delete(int $postId): Response
    {
        $post = $this->postManager->findById($postId);
        $this->postManager->delete($post);
        return $this->redirect("/php_blog_adventure/admin/posts");
    }
}