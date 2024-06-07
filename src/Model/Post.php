<?php

namespace src\model;

class Post implements EntityInterface
{
    use EntityTrait;
    protected string $title;
    protected string $content;

    protected string $intro;
    protected int $author_id;
    protected int $category_id;
    protected string $created_at;
    protected string $updated_at;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getAuthorId(): int
    {
        return $this->author_id;
    }

    /**
     * @param mixed $author_id
     */
    public function setAuthorId(int $author_id): void
    {
        $this->author_id = $author_id;
    }

    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    public function setCategoryId(int $category_id): void
    {
        $this->category_id = $category_id;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt(string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return string
     */
    public function getIntro(): string
    {
        return $this->intro;
    }

    /**
     * @param string $intro
     */
    public function setIntro(string $intro): void
    {
        $this->intro = $intro;
    }
}