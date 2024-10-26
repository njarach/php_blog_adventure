<?php

namespace src\Controller;

use Exception;
use src\Service\Manager\CommentManager;
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
        if ($this->request()->getRequestMethod() === 'POST') {
            try {
                $errors = $this->commentManager->validateCommentData($this->request()->getAllPostData());
                if (empty($errors)) {
                    $this->commentManager->createComment($this->request()->get('content'), $this->getCurrentUser()->getId(), $postId);
                    return $this->redirect("/php_blog_adventure/posts/{$postId}");
                } else {
                    return $this->render('blogpost/show.html.twig', [
                        'errors' => $errors,
                        'commentFormData' => $this->request()->getAllPostData(),
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
        //TODO: not required, maybe add this later
    }

    public function delete(int $postId)
    {
        //TODO: not required, maybe add this later
    }
}