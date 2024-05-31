<?php

namespace src\controller\AdminController;

use src\controller\AbstractController;

class UserController extends AbstractController
{
    // check role and authorization in service ?
    public function index()
    {
//        here add logic so an admin can view all the users for easier management
    }

    public function edit(int $postId)
    {
//        here add logic to edit a user's data
    }

    public function delete(int $postId)
    {
//        here add logic to delete a user
    }
}