<?php

namespace src\Controller;

use Exception;
use src\Service\Manager\CommentManager;
use src\Service\Manager\PostManager;

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
    public function create(int $postId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Checking datas sent by the user, return error to be displayed on the blogpost#show if any
            $commentErrors = $this->commentManager->validateCommentData($_POST);
            if (empty($errors)) {
                $this->commentManager->createComment($_POST['content'], 1, $postId);
                // TODO Redirect to the post's show page after successful comment creation ? create a redirect method in abstract controller ?
                $this->redirectToRoute("/php_blog_adventure/posts/{$postId}");
            } else {
                echo $this->render('blogpost/show.html.twig', [
                    'commentErrors' => $commentErrors,
                    'commentFormData' => $_POST,
                ]);
            }
        } else {
            // TODO Redirect to the post's show page after successful comment creation ? create a redirect method in abstract controller ?
            $this->redirectToRoute("/php_blog_adventure/posts/{$postId}");
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