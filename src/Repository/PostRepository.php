<?php

namespace src\Repository;

use PDO;
use src\model\Post;

class PostRepository extends AbstractRepository
{
    protected function getTableName(): string
    {
        return 'post';
    }
}