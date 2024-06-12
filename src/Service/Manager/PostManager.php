<?php

namespace src\Service\Manager;

use Exception;
use src\model\Post;
use src\Repository\PostRepository;

class PostManager
{
    private PostRepository $postRepository;
    public function __construct()
    {
        $this->postRepository = new PostRepository();
    }

    /**
     * @throws Exception
     */
    public function findAll(): array
    {
        return $this->postRepository->findAll();
    }

    /**
     * @throws Exception
     */
    public function findById(int $postId): ?Post
    {
        return $this->postRepository->findById($postId);
    }

}