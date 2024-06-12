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
    public function findAll(): ?array
    {
        // TODO : voir pour rajouter ces optimisations sur les autres méthodes
        $rows = $this->fetchAll();
        if (count($rows)) {
            $posts = [];
            foreach ($rows as $row) {
                $post = new Post();
                $post->setContent($row['content']);
                $post->setId($row['id']);
                $post->setTitle($row['title']);
                $post->setCategoryId($row['category_id']);
                $post->setIntro($row['intro']);
                $post->setAuthorId($row['author_id']);
                $post->setCreatedAt($row['created_at']);
                $post->setUpdatedAt($row['updated_at']);
                $posts[] = $post;
            }
            return $posts;
        }
        return null;
    }

    /**
     * @throws Exception
     */
    public function findById(int $id): ?Post
    {
        $row =  $this->fetchById($id);
        if (!empty($row)) {
            $post = new Post();
            $post->setContent($row['content']);
            $post->setId($row['id']);
            $post->setTitle($row['title']);
            $post->setCategoryId($row['category_id']);
            $post->setIntro($row['intro']);
            $post->setAuthorId($row['author_id']);
            $post->setCreatedAt($row['created_at']);
            $post->setUpdatedAt($row['updated_at']);
            return $post;
        } else {
            throw new Exception("Aucune donnée n'a été trouvée !");
        }
    }

    /**
     * @throws Exception
     */
    public function findBy(array $criteria): array
    {
        // TODO : idéalement, findBy ne renvoie pas d'exception mais juste un tableau qui ne contient aucun résultat
        $rows =  $this->fetchBy($criteria);
        $posts = [];
        if (!empty($rows)) {
            foreach ($rows as $row){
                $post = new Post();
                $post->setContent($row['content']);
                $post->setId($row['id']);
                $post->setTitle($row['title']);
                $post->setCategoryId($row['category_id']);
                $post->setIntro($row['intro']);
                $post->setAuthorId($row['author_id']);
                $post->setCreatedAt($row['created_at']);
                $post->setUpdatedAt($row['updated_at']);
                $posts[] = $post;
            }
            return $posts;
        } else {
            throw new Exception("Aucune donnée n'a été trouvée !");
        }
    }

    /**
     * @throws Exception
     */
    public function findOneBy(array $criteria): ?Post
    {
        $row = $this->fetchOneBy($criteria);
        if (!empty($row)) {
            $post = new Post();
            $post->setContent($row['content']);
            $post->setId($row['id']);
            $post->setTitle($row['title']);
            $post->setCategoryId($row['category_id']);
            $post->setIntro($row['intro']);
            $post->setAuthorId($row['author_id']);
            $post->setCreatedAt($row['created_at']);
            $post->setUpdatedAt($row['updated_at']);
            return $post;
        } else {
            throw new Exception("Aucune donnée n'a été trouvée !");
        }
    }
}