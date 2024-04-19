<?php

namespace src\Repository;

use src\model\BlogPost;

class BlogPostRepository extends Repository
{
    public function findAll(): array
    {
        $statement = $this->connection->getInstance()->query(
            "SELECT * FROM posts ORDER BY created_at DESC LIMIT 0, 5"
        );
        $posts = [];
        while (($row = $statement->fetch())) {
            $post = new BlogPost();
            $post->title = $row['title'];
            $post->created_at = $row['created_at'];
            $post->content = $row['content'];
            $post->id = $row['id'];
            $post->author_id = $row['author_id'];
            $post->category_id = $row['category_id'];

            $posts[] = $post;
        }

        return $posts;
    }

    public function findById($id): BlogPost
    {
        $statement = $this->connection->getInstance()->prepare(
            "SELECT * FROM posts WHERE id = ?"
        );
        $statement->execute([$id]);

        $row = $statement->fetch();
        $post = new BlogPost();
        $post->title = $row['title'];
        $post->created_at = $row['created_at'];
        $post->content = $row['content'];
        $post->id = $row['id'];
        $post->author_id = $row['author_id'];
        $post->category_id = $row['category_id'];

        return $post;
    }
}