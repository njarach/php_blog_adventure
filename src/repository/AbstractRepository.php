<?php

namespace src\repository;

use src\config\DatabaseConnection;

class AbstractRepository
{
    protected DatabaseConnection $connection;

    public function __construct()
    {
        $this->connection = new DatabaseConnection();
    }
}