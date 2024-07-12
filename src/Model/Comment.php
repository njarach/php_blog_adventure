<?php

namespace src\model;

use Exception;
use src\Repository\UserRepository;

class Comment implements EntityInterface
{
    use EntityTrait;
    protected int $post_id;
    protected int $user_id;
    protected string $content;
    protected string $created_at;
    protected bool $reviewed;
    protected string $author_name;

    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->post_id;
    }

    /**
     * @param int $post_id
     */
    public function setPostId(int $post_id): void
    {
        $this->post_id = $post_id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return bool
     */
    public function isReviewed(): bool
    {
        return $this->reviewed;
    }

    /**
     * @param bool $reviewed
     */
    public function setReviewed(bool $reviewed): void
    {
        $this->reviewed = $reviewed;
    }

    /**
     * @throws Exception
     */
    public function getAuthorName(): string
    {
        if (!$this->author_name) {
            $userRepository = new UserRepository();
            $author = $userRepository->findOneBy(['id' => $this->user_id]);
            $this->author_name = $author?->getUsername();
        }
        return $this->author_name;
    }

    public function setAuthorName(string $authorName): void
    {
        $this->author_name = $authorName;
    }
}