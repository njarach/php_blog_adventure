<?php

namespace src\Repository;

use Exception;
use src\model\Comment;
use src\model\User;

class UserRepository extends AbstractRepository
{

    public function findAll(): ?array
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

    /**
     * @throws Exception
     */
    public function findOneBy(array $criteria): ?User
    {
        $rows = $this->fetchOneBy($criteria);
        if (!empty($row)) {
            $user = new User();
            $user->setProperties($row);
            return $user;
        } else {
            throw new Exception("Aucune donnée n'a été trouvée !");
        }
    }

    protected function getTableName(): string
    {
        return 'user';
    }
}