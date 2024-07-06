<?php

namespace src\Repository;

use PDO;

class UserRepository extends AbstractRepository
{

    public function getUserNameById(int $userId): ?string
    {
        $sql = "SELECT username FROM user WHERE id = :userId";
        $statement = $this->connection->getInstance()->prepare($sql);
        $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result['username'] ?? null;
    }

    protected function getTableName(): string
    {
        return 'user';
    }

    public function findAll(): array
    {
        // TODO: Implement findAll() method.
    }

    public function findById(int $id): ?object
    {
        // TODO: Implement findById() method.
    }

    public function findBy(array $criteria): array
    {
        // TODO: Implement findBy() method.
    }

    public function findOneBy(array $criteria): ?object
    {
        // TODO: Implement findOneBy() method.
    }
}