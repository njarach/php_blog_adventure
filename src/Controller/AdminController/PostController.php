<?php

namespace src\Controller\AdminController;

use Exception;
use src\controller\AbstractController;
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
        if ($this->request()->getRequestMethod() === 'POST') {
            $errors = $this->postManager->validatePostData($this->request()->getAllPostData());
            if (empty($errors)) {
                $this->postManager->createPost($this->request()->get('title'), $this->request()->get('content'), $this->request()->get('category_id'), $this->getCurrentUser()
                    ->getId(), $this->request()->get('intro'));
                return $this->redirect("/php_blog_adventure/posts");
            } else {
                $categories = $this->postManager->getAllCategories();
                return $this->render('blogpost/new.html.twig', [
                    'categories' => $categories,
                    'errors' => $errors,
                    'formData' => $this->request()->getAllPostData()
                ]);
            }
        } else {
//           TODO Categories are not required in this project so they will not be refactored yet.
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
        if ($this->request()->getRequestMethod() === 'POST') {
            $errors = $this->postManager->validatePostData($this->request()->getAllPostData());
            if (empty($errors)) {
                $this->postManager->edit($postId, $this->request()->get('title'), $this->request()->get('content'), $this->request()->get('category_id'),
                    $this->request()->get('intro'));
                return $this->redirect("/php_blog_adventure/admin/posts");
            } else {
                $categories = $this->postManager->getAllCategories();
                $post = $this->postManager->findById($postId);
                return $this->render('blogpost/edit.html.twig', [
                    'post' => $post,
                    'categories' => $categories,
                    'errors' => $errors,
                    'formData' => $this->request()->getAllPostData()
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