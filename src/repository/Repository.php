<?php

namespace src\repository;

use src\config\DatabaseConnection;

class Repository
{
    protected DatabaseConnection $connection;

    public function __construct()
    {
        $this->connection = new DatabaseConnection();
    }
}