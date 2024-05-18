<?php

namespace src\Repository;

class CategoryRepository extends AbstractRepository
{

    protected function getTableName(): string
    {
        return 'category';
    }
}