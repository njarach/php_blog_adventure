<?php

namespace src\Controller\AdminController;

interface CrudControllerInterface
{
    public function index();
    public function show(int $postId);
    public function create();
    public function edit(int $postId);
    public function delete(int $postId);
}