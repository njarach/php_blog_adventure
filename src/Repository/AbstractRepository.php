<?php

namespace src\repository;

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

    /**
     * @throws Exception
     */
    protected function new(EntityInterface $entity)
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
            throw new Exception('Failed to create new entity: ' . implode(', ', $statement->errorInfo()));
        }
    }

    /**
     * @throws Exception
     */
    public function edit(EntityInterface $entity)
    {
        $properties = $entity->getProperties();

        $primaryKey = 'id';
        if (!isset($properties[$primaryKey])) {
            throw new \Exception('Primary key value is missing. Do not forget to set it when feeding your result in the object.');
        }
        $primaryKeyValue = $properties[$primaryKey];
        unset($properties[$primaryKey]); // Primary key should not be edited, so it is removed from the $properties array.

        // Filter out null values to only update provided properties. That way if a user doesn't set a property, it goes to the next to be updated.
        $properties = array_filter($properties, fn($value) => $value !== null);
        $columns = array_keys($properties);

        $setClause = implode(", ", array_map(fn($col) => "$col = :$col", $columns));

        $sql = "UPDATE " . $this->getTableName() . " SET " . $setClause . " WHERE $primaryKey = :$primaryKey";
        $statement = $this->connection->getInstance()->prepare($sql);

        // Bind the values dynamically
        foreach ($properties as $column => $value) {
            $statement->bindValue(":$column", $value);
        }
        // Bind the primary key value
        $statement->bindValue(":$primaryKey", $primaryKeyValue);

        if (!$statement->execute()) {
            throw new \Exception('Failed to update entity: ' . implode(', ', $statement->errorInfo()));
        }
    }

    /**
     * @throws Exception
     */
    public function delete(EntityInterface $entity)
    {
        // Assuming 'id' is the primary key
        $primaryKey = 'id';
        $properties = $entity->getProperties();

        if (!isset($properties[$primaryKey])) {
            throw new \Exception('Primary key value is missing. Do not forget to set it when feeding the results in the object.');
        }

        $primaryKeyValue = $properties[$primaryKey];

        $sql = "DELETE FROM " . $this->getTableName() . " WHERE $primaryKey = :$primaryKey";
        $statement = $this->connection->getInstance()->prepare($sql);

        // Bind the primary key value
        $statement->bindValue(":$primaryKey", $primaryKeyValue);

        if (!$statement->execute()) {
            throw new \Exception('Failed to delete entity: ' . implode(', ', $statement->errorInfo()));
        }
    }
}