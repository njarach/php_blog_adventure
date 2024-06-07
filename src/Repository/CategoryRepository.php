<?php

namespace src\Repository;

use src\model\Category;

class CategoryRepository extends AbstractRepository
{
    protected function getTableName(): string
    {
        return 'category';
    }

    public function findById(int $id): ?Category
    {
        $rows = $this->fetchById($id);
        // TODO : ajouter les if empty etc ?
        $category = new Category();
        // TODO : var_dumper pour voir ce qui est retourné, voir abstractrepo.
        // $category->setName($rows['name']); ...
        // return $category ?
    }

    public function findAll(): array
    {
        // TODO: Implement findAll() method.
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