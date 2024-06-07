<?php

namespace src\Repository;

use Exception;
use src\model\Comment;

class CommentRepository extends AbstractRepository
{

    protected function getTableName(): string
    {
        return 'comment';
    }

    /**
     * @throws Exception
     */
    public function findAll(): array
    {
        $rows =  $this->fetchAll();
        $comments = [];
        if (!empty($rows)) {
            foreach ($rows as $row){
                $comment = new Comment();
                $comment->setContent($row['content']);
                $comment->setId($row['id']);
                $comment->setUserId($row['user_id']);
                $comment->setCreatedAt($row['created_at']);
                $comment->setPostId($row['post_id']);
                $comments[] = $comment;
            }
            return $comments;
        } else {
            throw new Exception("Aucune donnée n'a été trouvée !");
        }
    }

    /**
     * @throws Exception
     */
    public function findById(int $id): ?Comment
    {
        $row =  $this->fetchById($id);
        if (!empty($row)) {
            $comment = new Comment();
            $comment->setContent($row['content']);
            $comment->setId($row['id']);
            $comment->setUserId($row['user_id']);
            $comment->setCreatedAt($row['created_at']);
            $comment->setPostId($row['post_id']);
            return $comment;
        } else {
            throw new Exception("Aucune donnée n'a été trouvée !");
        }
    }

    /**
     * @throws Exception
     */
    public function findBy(array $criteria): array
    {
        $rows =  $this->fetchBy($criteria);
        $comments = [];
        if (!empty($rows)) {
            foreach ($rows as $row){
                $comment = new Comment();
                $comment->setContent($row['content']);
                $comment->setId($row['id']);
                $comment->setUserId($row['user_id']);
                $comment->setCreatedAt($row['created_at']);
                $comment->setPostId($row['post_id']);
                $comments[] = $comment;
            }
            return $comments;
        } else {
            throw new Exception("Aucune donnée n'a été trouvée !");
        }
    }

    /**
     * @throws Exception
     */
    public function findOneBy(array $criteria): ?Comment
    {
        $row = $this->findOneBy($criteria);
        if (!empty($row)) {
            $comment = new Comment();
            $comment->setContent($row['content']);
            $comment->setId($row['id']);
            $comment->setUserId($row['user_id']);
            $comment->setCreatedAt($row['created_at']);
            $comment->setPostId($row['post_id']);
            return $comment;
        } else {
            throw new Exception("Aucune donnée n'a été trouvée !");
        }
    }
}