<?php

namespace src\controller\AdminController;

use src\controller\AbstractController;

class PostController extends CrudController
{
    // check role and authorization in service ?
    public function index()
    {
//        here add logic so an admin can view all the blogposts for easier management
    }
    public function new()
    {
//        here add logic to create new blogpost
    }
    public function edit(int $postId)
    {
//        here add logic to edit a blogpost
    }

    public function delete(int $postId)
    {
//        here add logic to delete a blogpost
    }

    public function show(int $postId)
    {
        // TODO: Implement show() method.
    }
}