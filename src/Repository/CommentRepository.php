<?php

namespace src\Repository;

class CommentRepository extends AbstractRepository
{

    protected function getTableName(): string
    {
        return 'comment';
    }
}