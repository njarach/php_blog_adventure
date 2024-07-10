<?php

namespace src\controller;

use Exception;
use src\Service\Manager\CommentManager;
use src\Service\Manager\PostManager;

class CommentController extends AbstractController
{
    private CommentManager $commentManager;
    private PostManager $postManager;
    public function __construct()
    {
        $this->commentManager = new CommentManager();
        $this->postManager = new PostManager();
    }

    /**
     * @throws Exception
     */
    public function create(int $postId)
    {
        $post = $this->postManager->findById($postId);
        $comments = $this->commentManager->getPostComments($postId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // On vérifie les données par l'utilisateur, la méthode retourne les erreurs le cas échéant
            $commentErrors = $this->commentManager->validateCommentData($_POST);
            if (empty($errors)) {
                $this->commentManager->createComment($_POST['content'], 1, $postId);
                echo $this->render('blogpost/show.html.twig', [
                    'post' => $post,
                    'comments'=> $comments
                ]);
            } else {
                echo $this->render('blogpost/show.html.twig', [
                    'commentErrors' => $commentErrors,
                    'commentFormData' => $_POST
                ]);
            }
        } else {
            echo $this->render('blogpost/show.html.twig', [
                'post' => $post,
                'comments'=> $comments
            ]);
        }
    }

    public function edit(int $commentId)
    {
//        here add logic so a user can edit one of his own comments
    }

    public function delete(int $postId)
    {
//        here add logic so a user can delete one of his own comments
    }
}