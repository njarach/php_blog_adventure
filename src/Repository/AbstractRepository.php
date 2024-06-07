<?php

namespace src\repository;

use PDO;
use src\config\DatabaseConnection;

abstract class AbstractRepository implements RepositoryInterface
{
    protected DatabaseConnection $connection;

    public function __construct()
    {
        $this->connection = new DatabaseConnection();
    }

    abstract protected function getTableName(): string;

    protected function fetchAll(): array
    {
        $statement = $this->connection->getInstance()->query("SELECT * FROM " . $this->getTableName());
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function fetchById(int $id): ?array
    {
        $statement = $this->connection->getInstance()->prepare("SELECT * FROM " . $this->getTableName() . " WHERE id = :id");
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    protected function fetchBy(array $criteria): array
    {
        $sql = "SELECT * FROM " . $this->getTableName() . " WHERE ";
        $conditions = [];
        $params = [];
        foreach ($criteria as $key => $value) {
            $conditions[] = "$key = :$key";
            $params[":$key"] = $value;
        }
        $sql .= implode(' AND ', $conditions);
        $statement = $this->connection->getInstance()->prepare($sql);
        foreach ($params as $param => $value) {
            $statement->bindParam($param, $value);
        }
        $statement->execute($params);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function fetchOneBy(array $criteria): ?array
    {
        $sql = "SELECT * FROM " . $this->getTableName() . " WHERE ";
        $conditions = [];
        $params = [];
        foreach ($criteria as $key => $value) {
            $conditions[] = "$key = :$key";
            $params[":$key"] = $value;
        }
        $sql .= implode(' AND ', $conditions);
        $statement = $this->connection->getInstance()->prepare($sql);
        foreach ($params as $param => $value) {
            $statement->bindParam($param, $value);
        }
        $statement->execute($params);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result?:null;
    }
}