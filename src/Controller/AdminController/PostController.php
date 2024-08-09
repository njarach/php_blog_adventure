<?php

namespace src\controller\AdminController;

use Exception;
use src\Service\Manager\CommentManager;
use src\Service\Manager\PostManager;

class PostController extends CrudController
{
    private PostManager $postManager;
    private CommentManager $commentManager;

    public function __construct()
    {
        $this->postManager = new PostManager();
        $this->commentManager = new CommentManager();
    }

    // check role and authorization in service ?

    /**
     * @throws Exception
     */
    public function index()
    {
        $blogPosts = $this->postManager->findAll();
        echo $this->render('blogpost/index.html.twig', [
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
                $this->postManager->createPost($_POST['title'], $_POST['content'], $_POST['category_id'], $_POST['intro']);
                echo $this->render('blogpost/index.html.twig', [
                    'posts' => $this->postManager->findAll()
                ]);
            } else {
                $categories = $this->postManager->getAllCategories();
                echo $this->render('blogpost/new.html.twig', [
                    'categories' => $categories,
                    'errors' => $errors,
                    'formData' => $_POST
                ]);
            }
        } else {
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
                echo $this->render('blogpost/index.html.twig', [
                    'posts' => $this->postManager->findAll()
                ]);
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
        echo $this->render('blogpost/index.html.twig',[
            'posts'=>$this->postManager->findAll()
        ]);
    }

    /**
     * @throws Exception
     */
    public function show(int $postId)
    {
        $blogPost = $this->postManager->findById($postId);
        if ($blogPost) {
            $comments = $this->commentManager->getPostComments($postId);
            echo $this->render('blogpost/show.html.twig', [
                'post' => $blogPost,
                'comments'=>$comments
            ]);
        } else {
            http_response_code(404);
            echo $this->render('error/error.html.twig', [
                'errorCode'=>404,
                'errorMessage'=>"Aucun article trouvé pour l'id $postId..."
            ]);
        }
    }
}