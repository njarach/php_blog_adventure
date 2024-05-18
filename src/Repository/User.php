<?php

namespace src\Repository;

class User extends AbstractRepository
{

    protected function getTableName(): string
    {
        return 'user';
    }
}