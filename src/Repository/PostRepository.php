<?php

namespace src\Repository;

use src\model\Post;

class PostRepository extends AbstractRepository
{
    public function findAll(): array
    {
        $statement = $this->connection->getInstance()->query(
            "SELECT * FROM post ORDER BY created_at DESC LIMIT 0, 5"
        );
        $posts = [];
        while (($row = $statement->fetch())) {
            $post = $this->getBlogPost($row);
            $posts[] = $post;
        }
        return $posts;
    }

    public function findById(int $id): ?Post
    {
        $statement = $this->connection->getInstance()->prepare(
            "SELECT * FROM post WHERE id = ?"
        );
        $statement->bindValue(1, $id, \PDO::PARAM_INT); // Bind the parameter using positional placeholders
        $statement->execute();
        $row = $statement->fetch();
        $post = null;
        if ($row) {
            $post = $this->getBlogPost($row);
            $statement->closeCursor();
        }
        return $post;
    }

    /**
     * @param mixed $row
     * @return Post
     */
    private function getBlogPost(mixed $row): Post
    {
        $post = new Post();
        $post->setTitle($row['title']);
        $post->setCreatedAt($row['created_at']);
        $post->setContent($row['content']);
        $post->setId($row['id']);
        $post->setAuthorId($row['author_id']);
        $post->setCategoryId($row['category_id']);
        return $post;
    }

}