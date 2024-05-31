<?php

namespace src\controller\AdminController;

interface CrudControllerInterface
{
    public function index();
    public function show(int $postId);
    public function new();
    public function edit(int $postId);
    public function delete(int $postId);
}