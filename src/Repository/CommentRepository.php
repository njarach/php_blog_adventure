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
        $rows = $this->fetchAll();
        return $this->getComments($rows);
    }


    /**
     * @throws Exception
     */
    public function findById(int $id): ?Comment
    {
        $row = $this->fetchById($id);
        return $this->getComment($row);
    }

    /**
     * @throws Exception
     */
    public function findBy(array $criteria): ?array
    {
        $rows = $this->fetchBy($criteria);
        return $this->getComments($rows);
    }

    /**
     * @throws Exception
     */
    public function findOneBy(array $criteria): ?Comment
    {
        $row = $this->fetchOneBy($criteria);
        return $this->getComment($row);
    }

    /**
     * @throws Exception
     */
    public function add(Comment $comment): void
    {
        $this->new($comment);
    }

    /**
     * @param bool|array $rows
     * @return array
     * @throws Exception
     */
    private function getComments(bool|array $rows): array
    {
        if (count($rows)) {
            $comments = [];
            foreach ($rows as $row) {
                $comment = $this->createCommentObject($row);
                $comments[] = $comment;
            }
            return $comments;
        }
        return [];
    }

    /**
     * @param bool|array $row
     * @return Comment
     * @throws Exception
     */
    private function getComment(bool|array $row): Comment
    {
        if (!empty($row)) {
            return $this->createCommentObject($row);
        } else {
            throw new Exception("Aucun commentaire n'a été trouvé.");
        }
    }

    /**
     * @param mixed $row
     * @return Comment
     * @throws Exception
     */
    private function createCommentObject(mixed $row): Comment
    {
        $comment = new Comment();
        $comment->setProperties($row);
        $userRepository = new UserRepository();
        $author = $userRepository->findOneBy(['id' => $comment->getUserId()]);
        if (!empty($author)) $comment->authorName = $author->getUsername();
        return $comment;
    }
}