<?php

namespace src\Repository;

use Exception;
use src\model\Post;

class PostRepository extends AbstractRepository
{
    /**
     * @return string
     */
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
        return $this->getPosts($rows);
    }

    /**
     * @throws Exception
     */
    public function findById(int $id): ?Post
    {
        $row = $this->fetchById($id);
        return $this->getPost($row);
    }

    /**
     * @throws Exception
     */
    public function findBy(array $criteria): array
    {
        $rows = $this->fetchBy($criteria);
        return $this->getPosts($rows);
    }

    /**
     * @throws Exception
     */
    public function findOneBy(array $criteria): Post
    {
        $row = $this->fetchOneBy($criteria);
        return $this->getPost($row);
    }

    /**
     * @throws Exception
     */
    public function findLatest(): Post
    {
        $row = $this->fetchLatest();
        return $this->getPost($row);
    }

    /**
     * @param bool|array $rows
     * @return array
     * @throws Exception
     */
    private function getPosts(bool|array $rows): array
    {
        if (count($rows)) {
            $posts = [];
            foreach ($rows as $row) {
                $post = $this->createPostObject($row);
                $posts[] = $post;
            }
            return $posts;
        }
        return [];
    }

    /**
     * @param bool|array $row
     * @return Post
     * @throws Exception
     */
    private function getPost(bool|array $row): Post
    {
        if (!empty($row)) {
            return $this->createPostObject($row);
        } else {
            throw new Exception("Aucun article n'a été trouvé !");
        }
    }

    /**
     * @param bool|array $row
     * @return Post
     * @throws Exception
     */
    private function createPostObject(bool|array $row): Post
    {
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