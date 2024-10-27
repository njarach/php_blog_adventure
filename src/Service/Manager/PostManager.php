<?php

namespace src\Service\Manager;

use Exception;
use src\model\Post;
use src\Repository\CategoryRepository;
use src\Repository\PostRepository;
use src\Repository\UserRepository;

class PostManager
{
    private PostRepository $postRepository;
    private CategoryRepository $categoryRepository;

    private array $errors = [];

    public function __construct()
    {
        $this->postRepository = new PostRepository();
        $this->categoryRepository = new CategoryRepository();
    }

    /**
     * @throws Exception
     */
    public function findAll(): ?array
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

    /**
     * @throws Exception
     */
    public function findLatestPost(): Post
    {
        return $this->postRepository->findLatest();
    }

    /**
     * @throws Exception
     */
    public function findOneBy(array $array): ?Post
    {
        return $this->postRepository->findOneBy($array);
    }

    /**
     * @throws Exception
     */
    public function edit(int $postId, string $title, string $content, int $categoryId, string $intro): Post
    {
        try {
            $existingPost = $this->postRepository->findById($postId);
            if ($existingPost) {
                $existingPost->setTitle($title);
                $existingPost->setContent($content);
                $existingPost->setCategoryId($categoryId);
                $existingPost->setIntro($intro);
                $currentDateTime = date('Y-m-d H:i:s');
                $existingPost->setUpdatedAt($currentDateTime);
                $this->postRepository->edit($existingPost);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $existingPost;
    }

    /**
     * @throws Exception
     * This is used most notably to display categories' names on forms
     */
    public function getAllCategories(): array
    {
        return $this->categoryRepository->findAll();
    }

    /**
     * @throws Exception
     */
    public function createPost(string $title, string $content, int $categoryId, int $authorId, string $intro): ?Post
    {
        $newPost = new Post();
        try {
            if ($title && $content && $categoryId) {
                $newPost->setTitle($title);
                $newPost->setContent($content);
                $newPost->setCategoryId($categoryId);
                $newPost->setIntro($intro);
                $newPost->setAuthorId($authorId);
                $this->postRepository->add($newPost);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $newPost;
    }

    /**
     * @throws Exception
     */
    public function delete(Post $post): void
    {
        $this->postRepository->delete($post);
    }

    /**
     * @param array $data
     * @return array Returns an array of errors. Array is empty if no errors are found.
     */
    public function validatePostData(array $data): array
    {
        // Reminder : we use this to have an empty array, always empty when instancing this object
        $errors = $this->errors;

        if (!$this->checkPost($data['title'])) {
            $errors['title'] = 'Vous devez renseigner un titre valide.';
        }
        if (!$this->checkPost($data['content'])) {
            $errors['content'] = "Le contenu de l'article ne doit pas être vide.";
        }
        if (!$this->checkPost($data['category_id'])) {
            $errors['category_id'] = 'Veuillez sélectionner une catégorie.';
        }
        if (!$this->checkPost($data['intro'])) {
            $errors['intro'] = "L'intro de l'article ne doit pas être vide.";
        }
        return $errors;
    }

    private function checkPost($data): bool
    {
        return isset($data) && !empty(trim($data));
    }

    /**
     * @throws Exception
     */
    public function getAuthorName(int $authorId): ?string
    {
        $userRepository = new UserRepository();
        $author = $userRepository->findOneBy(['id' => $authorId]);
        return $author?->getUsername();
    }
}