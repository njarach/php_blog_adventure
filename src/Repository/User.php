<?php

namespace src\Repository;

class User extends AbstractRepository
{

    protected function getTableName(): string
    {
        return 'user';
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

    public function findOneBy(array $criteria): ?object
    {
        // TODO: Implement findOneBy() method.
    }
}