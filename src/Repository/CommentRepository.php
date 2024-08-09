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
     * Returns an array of Comment objects.
     */
    public function findAll(): array
    {
        $rows =  $this->fetchAll();
        $comments = [];
        if (!empty($rows)) {
            foreach ($rows as $row){
                $comment = new Comment();
                $comment->setProperties($row);
                $comments[] = $comment;
            }
            return $comments;
        } else {
            throw new Exception("Aucun commentaire n'a été trouvé !");
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
            $comment->setProperties($row);
            return $comment;
        } else {
            return null;
        }
    }

    /**
     * @throws Exception
     */
    public function findBy(array $criteria): ?array
    {
        $rows =  $this->fetchBy($criteria);
        $comments = [];
        if (!empty($rows)) {
            foreach ($rows as $row){
                $comment = new Comment();
                $comment->setProperties($row);
                $comments[] = $comment;
            }
            return $comments;
        } else {
            return null;
        }
    }

    /**
     * @throws Exception
     */
    public function findOneBy(array $criteria): ?Comment
    {
        $row = $this->fetchOneBy($criteria);
        if (!empty($row)) {
            $comment = new Comment();
            $comment->setProperties($row);
            return $comment;
        } else {
            return null;
        }
    }

    /**
     * @throws Exception
     */
    public function add(Comment $comment): void
    {
        $this->new($comment);
    }
}