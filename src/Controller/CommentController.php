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
        $blogPost = $this->postManager->findById($postId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Checking datas sent by the user, return error to be displayed on the blogpost#show if any
            $commentErrors = $this->commentManager->validateCommentData($_POST);
            if (empty($errors)) {
                $this->commentManager->createComment($_POST['content'], 1, $postId);
                $authorName = $this->postManager->getAuthorName($blogPost->getAuthorId());
                $comments = $this->commentManager->getPostComments($postId);
                echo $this->render('blogpost/show.html.twig', [
                    'post' => $blogPost,
                    'comments'=> $comments,
                    'authorName'=>$authorName
                ]);
            } else {
                $authorName = $this->postManager->getAuthorName($blogPost->getAuthorId());
                $comments = $this->commentManager->getPostComments($postId);
                echo $this->render('blogpost/show.html.twig', [
                    'commentErrors' => $commentErrors,
                    'commentFormData' => $_POST,
                    'comments'=> $comments,
                    'authorName'=>$authorName
                ]);
            }
        } else {
            $authorName = $this->postManager->getAuthorName($blogPost->getAuthorId());
            $comments = $this->commentManager->getPostComments($postId);
            echo $this->render('blogpost/show.html.twig', [
                'post' => $blogPost,
                'comments'=> $comments,
                'authorName'=>$authorName
            ]);
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