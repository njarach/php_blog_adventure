<?php

namespace src\controller\AdminController;

class CategoryController extends CrudController
{
    // check role and authorization in service ?
    public function index()
    {
//        here add logic so an admin can view all the categories for easier management
    }
    public function new()
    {
//        here add logic to create new category
    }
    public function edit(int $postId)
    {
//        here add logic to edit a category
    }

    public function delete(int $postId)
    {
//        here add logic to delete a category
    }

    public function show(int $postId)
    {
        // TODO: Implement show() method.
    }
}