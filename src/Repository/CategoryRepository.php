<?php

namespace src\Repository;

use Exception;
use src\model\Category;

class CategoryRepository extends AbstractRepository
{
    /**
     * @return string
     */
    protected function getTableName(): string
    {
        return 'category';
    }

    /**
     * @throws Exception
     */
    public function findAll(): array
    {
        $rows =  $this->fetchAll();
        $categories = [];
        if (!empty($rows)) {
            foreach ($rows as $row){
                $category = new Category();
                $category->setProperties($row);
                $categories[] = $category;
            }
            return $categories;
        } else {
            return [];
        }
    }

    /**
     * @throws Exception
     */
    public function findById(int $id): ?Category
    {
        $row =  $this->fetchById($id);
        if (!empty($row)) {
            $category = new Category();
            $category->setProperties($row);
            return $category;
        } else {
            throw new Exception("Aucune catégorie n'a été trouvée !");
        }
    }

    /**
     * @throws Exception
     */
    public function findBy(array $criteria): array
    {
        $rows =  $this->fetchBy($criteria);
        $categories = [];
        if (!empty($rows)) {
            foreach ($rows as $row){
                $category = new Category();
                $category->setProperties($row);
                $categories[] = $category;
            }
            return $categories;
        } else {
            return [];
        }
    }

    /**
     * @throws Exception
     */
    public function findOneBy(array $criteria): ?Category
    {
        $row = $this->fetchOneBy($criteria);
        if (!empty($row)) {
            $category = new Category();
            $category->setProperties($row);
            return $category;
        } else {
            throw new Exception("Aucune catégorie n'a été trouvée !");
        }
    }
}