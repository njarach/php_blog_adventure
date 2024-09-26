<?php

namespace src\Controller;

use Exception;
use src\Service\Manager\CommentManager;
use src\Service\Manager\PostManager;
use src\Service\Response;

class CommentController extends AbstractController
{
    private CommentManager $commentManager;
    public function __construct()
    {
        $this->commentManager = new CommentManager();
    }

    /**
     * @throws Exception
     */
    public function create(int $postId): Response
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $errors = $this->commentManager->validateCommentData($_POST);
                if (empty($errors)) {
                    $this->commentManager->createComment($_POST['content'], $this->getCurrentUser()->getId(), $postId);
                    return $this->redirect("/php_blog_adventure/posts/{$postId}");
                } else {
                    return $this->render('blogpost/show.html.twig', [
                        'errors' => $errors,
                        'commentFormData' => $_POST,
                    ]);
                }
            } catch (Exception $e) {
                return $this->render('error/error.html.twig',[
                    'errorCode'=>500,
                    'message'=>$e->getMessage()
                ]);
            }
        } else {
            return $this->redirect("/php_blog_adventure/posts/{$postId}");
        }
    }

    public function edit(int $commentId)
    {
        // not required, maybe add this later
    }

    public function delete(int $postId)
    {
        // not required, maybe add this later
    }
}