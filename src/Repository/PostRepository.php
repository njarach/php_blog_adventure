<?php

namespace src\Repository;

use Exception;
use src\model\Post;

class PostRepository extends AbstractRepository
{
    protected function getTableName(): string
    {
        return 'post';
    }

    /**
     * @throws Exception
     */
    public function add(Post $post): void
    {
        $this->new($post);
    }

    /**
     * @throws Exception
     */
    public function findAll(): array
    {
        $rows = $this->fetchAll();
        if (count($rows)) {
            $posts = [];
            foreach ($rows as $row) {
                $post = new Post();
                $post->setProperties($row);
                $userRepository = new UserRepository();
                $author = $userRepository->findOneBy(['id' => $post->getAuthorId()]);
                $commentRepository = new CommentRepository();
                $comments = $commentRepository->findBy(['post_id' => $post->getId()]);
                if (!empty($author)) $post->authorName = $author->getUsername();
                if (!empty($comments)) $post->comments = $comments;
                $posts[] = $post;
            }
            return $posts;
        }
        return [];
    }

    /**
     * @throws Exception
     */
    public function findById(int $id): ?Post
    {
        $row = $this->fetchById($id);
        if (!empty($row)) {
            $post = new Post();
            $post->setProperties($row);
            $userRepository = new UserRepository();
            $author = $userRepository->findOneBy(['id' => $post->getAuthorId()]);
            $commentRepository = new CommentRepository();
            $comments = $commentRepository->findBy(['post_id' => $post->getId()]);
            if (!empty($author)) $post->authorName = $author->getUsername();
            if (!empty($comments)) $post->comments = $comments;
            return $post;
        } else {
            throw new Exception("Aucun article n'a été trouvé.");
        }
    }

    /**
     * @throws Exception
     */
    public function findBy(array $criteria): array
    {
        $rows = $this->fetchBy($criteria);
        $posts = [];
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $post = new Post();
                $post->setProperties($row);
                $userRepository = new UserRepository();
                $author = $userRepository->findOneBy(['id' => $post->getAuthorId()]);
                $commentRepository = new CommentRepository();
                $comments = $commentRepository->findBy(['post_id' => $post->getId()]);
                if (!empty($author)) $post->authorName = $author->getUsername();
                if (!empty($comments)) $post->comments = $comments;
                $posts[] = $post;
            }
            return $posts;
        } else {
            return [];
        }
    }

    /**
     * @throws Exception
     */
    public function findOneBy(array $criteria): Post
    {
        $row = $this->fetchOneBy($criteria);
        if (!empty($row)) {
            $post = new Post();
            $post->setProperties($row);
            $userRepository = new UserRepository();
            $author = $userRepository->findOneBy(['id' => $post->getAuthorId()]);
            $commentRepository = new CommentRepository();
            $comments = $commentRepository->findBy(['post_id' => $post->getId()]);
            if (!empty($author)) $post->authorName = $author->getUsername();
            if (!empty($comments)) $post->comments = $comments;
            return $post;
        } else {
            throw new Exception("Aucun post n'a été trouvé !");
        }
    }

    /**
     * @throws Exception
     */
    public function findLatest(): Post{
        $row = $this->fetchLatest();
        $post = new Post();
        $post->setProperties($row);
        $userRepository = new UserRepository();
        $author = $userRepository->findOneBy(['id' => $post->getAuthorId()]);
        $commentRepository = new CommentRepository();
        $comments = $commentRepository->findBy(['post_id' => $post->getId()]);
        if (!empty($author)) $post->authorName = $author->getUsername();
        if (!empty($comments)) $post->comments = $comments;
        return $post;
    }
}