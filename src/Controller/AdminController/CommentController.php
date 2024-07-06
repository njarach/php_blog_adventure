<?php

namespace src\controller\AdminController;

use src\controller\AbstractController;

class CommentController extends CrudController
{
    // check role and authorization in service ?
    public function review(int $commentId)
    {
//        here add logic to review a comment posted by a user so it's displayed below the post
    }

    public function delete(int $commentId)
    {
//        here add logic to delete a comment posted by any user
    }

    public function edit(int $commentId)
    {
//        here add logic to edit a comment posted by any user
    }

    public function index()
    {
        // TODO: Implement index() method.
    }

    public function show(int $postId)
    {
        // TODO: Implement show() method.
    }

    public function create()
    {
        // TODO: Implement new() method.
    }
}