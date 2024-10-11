<?php

namespace src\Repository;

use Exception;
use PDO;
use src\config\DatabaseConnection;
use src\model\EntityInterface;
use src\model\Post;

abstract class AbstractRepository implements RepositoryInterface
{
    protected DatabaseConnection $connection;

    public function __construct()
    {
        $this->connection = new DatabaseConnection();
    }

    abstract protected function getTableName(): string;

    // This is used to get the table columns that are properly mapped in the DB
    protected function getTableColumns(): array|bool
    {
        $sql = "SHOW COLUMNS FROM " . $this->getTableName();
        $stmt = $this->connection->getInstance()->query($sql);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    protected function fetchAll(): array|bool
    {
        $statement = $this->connection->getInstance()->query("SELECT * FROM " . $this->getTableName());
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function fetchById(int $id): array|bool
    {
        $statement = $this->connection->getInstance()->prepare("SELECT * FROM " . $this->getTableName() . " WHERE id = :id");
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    protected function fetchBy(array $criteria): array|bool
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

    protected function fetchOneBy(array $criteria): array|bool
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
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    protected function fetchlatest(): array|bool
    {
        $sql = "SELECT * FROM " . $this->getTableName() . " ORDER BY id DESC LIMIT 1";
        $statement = $this->connection->getInstance()->prepare($sql);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @throws Exception
     */
    protected function new(EntityInterface $entity): void
    {
        $properties = $entity->getProperties();
        $columns = array_keys($properties);
        $placeholders = array_map(fn($col) => ":$col", $columns);

        $sql = "INSERT INTO " . $this->getTableName() . " (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $placeholders) . ")";
        $statement = $this->connection->getInstance()->prepare($sql);

        foreach ($properties as $column => $value) {
            $statement->bindValue(":$column", $value);
        }

        if (!$statement->execute()) {
            throw new Exception('La création de l entité a échouée: ' . implode(', ', $statement->errorInfo()));
        }
    }

    /**
     * @throws Exception
     */
    public function edit(EntityInterface $entity)
    {
        $properties = $entity->getProperties();
        $primaryKey = 'id';
        $primaryKeyValue = $properties[$primaryKey];

        $validColumns = $this->getTableColumns();

        $properties = array_filter($properties, fn($value, $key) => $value !== null && in_array($key, $validColumns), ARRAY_FILTER_USE_BOTH);
        $columns = array_keys($properties);

        $setClause = implode(", ", array_map(fn($col) => "$col = :$col", $columns));

        $sql = "UPDATE " . $this->getTableName() . " SET " . $setClause . " WHERE $primaryKey = :$primaryKeyValue";
        $statement = $this->connection->getInstance()->prepare($sql);

        foreach ($properties as $column => $value) {
            $statement->bindValue(":$column", $value);
        }

        $statement->bindValue(":$primaryKeyValue", $primaryKeyValue);

        if (!$statement->execute()) {
            throw new \Exception('Failed to update entity: ' . implode(', ', $statement->errorInfo()));
        }
    }

    /**
     * @throws Exception
     */
    public function delete(EntityInterface $entity)
    {
        $properties = $entity->getProperties();
        $primaryKey = 'id';

        $primaryKeyValue = $properties[$primaryKey];

        $sql = "DELETE FROM " . $this->getTableName() . " WHERE $primaryKey = :$primaryKey";
        $statement = $this->connection->getInstance()->prepare($sql);

        $statement->bindValue(":$primaryKey", $primaryKeyValue);

        if (!$statement->execute()) {
            throw new \Exception('Failed to delete entity: ' . implode(', ', $statement->errorInfo()));
        }
    }
}