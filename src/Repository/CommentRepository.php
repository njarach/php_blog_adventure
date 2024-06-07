<?php

namespace src\Repository;

class CommentRepository extends AbstractRepository
{

    protected function getTableName(): string
    {
        return 'comment';
    }

    public function findAll(): array
    {
        // TODO: Implement findAll() method.
    }

    public function findById(int $id): ?object
    {
        // TODO: Implement findById() method.
    }

    public function findBy(array $criteria): array
    {
        // TODO: Implement findBy() method.
    }

    public function findOneBy(array $criteria): ?array
    {
        // TODO: Implement findOneBy() method.
    }
}