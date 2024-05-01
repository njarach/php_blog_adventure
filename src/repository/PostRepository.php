<?php

namespace src\Repository;

use src\model\Post;

class PostRepository extends AbstractRepository
{
    public function findAll(): array
    {
        $statement = $this->connection->getInstance()->query(
            "SELECT * FROM posts ORDER BY created_at DESC LIMIT 0, 5"
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
            "SELECT * FROM posts WHERE id = ?"
        );
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetch();
        $post = null;
        if ($row) {
            $post = $this->getBlogPost($row);
//        $statement->closeCursor();
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