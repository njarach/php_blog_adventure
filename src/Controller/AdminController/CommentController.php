<?php

namespace src\Controller\AdminController;

use Exception;
use src\controller\AbstractController;
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
    public function review(int $commentId): Response
    {
        $this->commentManager->reviewComment($commentId);
        list($reviewedComments, $unreviewedComments) = $this->commentManager->getReviewSortedComments();
        return $this->render('admin/comments_list.html.twig',[
            'reviewedComments'=>$reviewedComments,
            'unreviewedComments'=>$unreviewedComments
        ]);
    }


    /**
     * This is used for admins to get a list of comments. They are sorted and allow admin to review them.
     * @throws Exception
     */
    public function index(): Response
    {
        list($reviewedComments, $unreviewedComments) = $this->commentManager->getReviewSortedComments();
        return $this->render('admin/comments_list.html.twig',[
            'reviewedComments'=>$reviewedComments,
            'unreviewedComments'=>$unreviewedComments
        ]);
    }

    public function show(int $postId)
    {
        //TODO: not required, maybe add this later
    }
}