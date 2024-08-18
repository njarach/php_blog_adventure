<?php

namespace src\Controller\AdminController;

use Exception;
use src\controller\AbstractController;
use src\Service\Manager\CommentManager;

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
    public function review(int $commentId)
    {
        $this->commentManager->reviewComment($commentId);
        list($reviewedComments, $unreviewedComments) = $this->commentManager->getReviewSortedComments();
        echo $this->render('admin/comments_list.html.twig',[
            'reviewedComments'=>$reviewedComments,
            'unreviewedComments'=>$unreviewedComments
        ]);
    }


    /**
     * @throws Exception
     * This is used for admins to get a list of comments. They are sorted and allow admin to review them.  
     */
    public function index()
    {
        list($reviewedComments, $unreviewedComments) = $this->commentManager->getReviewSortedComments();
        echo $this->render('admin/comments_list.html.twig',[
            'reviewedComments'=>$reviewedComments,
            'unreviewedComments'=>$unreviewedComments
        ]);
    }

    public function show(int $postId)
    {
        // TODO: Implement show() method.
        // not required, maybe add this later
    }
}