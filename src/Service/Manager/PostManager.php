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
    private UserRepository $userRepository;

    private array $errors = [];

    public function __construct()
    {
        $this->postRepository = new PostRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->userRepository = new UserRepository();
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

    /**
     * @throws Exception
     */
    public function edit(int $postId, string $title, string $content, int $categoryId, string $intro): ?Post
    {
        if ($title && $content && $categoryId && $intro) {
            // Retrieve the existing post from the database. This should throw an exception if, for some reason, none is found.
            $existingPost = $this->postRepository->findById($postId);

            if ($existingPost) {
                // Update the post properties with the ones provided by the user through the form
                $existingPost->setTitle($title);
                $existingPost->setContent($content);
                $existingPost->setCategoryId($categoryId);
                $existingPost->setIntro($intro);

                try {
                    $this->postRepository->edit($existingPost);
                } catch (Exception $e) {
                    echo 'Erreur: ' . $e->getMessage();
                }
                return $existingPost;
            } else {
                echo 'Erreur: Article non trouvé.';
            }
        } else {
            echo 'Erreur: Tous les champs sont requis.';
        }
        return null;
    }

    // This is useful ?
    public function getCategoryNameById(int $categoryId): ?string
    {
        return $this->categoryRepository->getCategoryNameById($categoryId);
    }

    /**
     * @throws Exception
     * This is used most notably to display categories' names on forms
     */
    public function getAllCategories(): array
    {
        return $this->categoryRepository->findAll();
    }

    // This is maybe useful ?
    public function getAuthorNameById(int $userId): ?string
    {
        return $this->userRepository->getUserNameById($userId);
    }

    public function createPost(string $title, string $content, int $categoryId, string $intro): ?Post
    {

        if ($title && $content && $categoryId) {
            $newPost = new Post();
            $newPost->setTitle($title);
            $newPost->setContent($content);
            $newPost->setCategoryId($categoryId);
            $newPost->setIntro($intro);
            $newPost->setAuthorId(1);

            try {
                $this->postRepository->add($newPost);
            } catch (Exception $e) {
                echo 'Erreur: ' . $e->getMessage();
            }
            return $newPost;
        }
        return null;
    }

    /**
     * @throws Exception
     */
    public function delete($post): void
    {
        $this->postRepository->delete($post);
    }

    public function validatePostData($data): array
    {
        // Un tableau vide, toujours vide à l'instanciation
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

    public function checkPost($data): bool
    {
        return isset($data) && !empty(trim($data));
    }

}