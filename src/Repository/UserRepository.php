<?php

namespace src\Repository;

use Exception;
use src\model\User;

class UserRepository extends AbstractRepository
{

    /**
     * @throws Exception
     */
    public function findAll(): ?array
    {
        $rows = $this->fetchAll();
        $users = [];
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $user = new User();
                $user->setProperties($row);
                $users[] = $user;
            }
            return $users;
        } else {
            throw new Exception("Aucun utilisateur n'a été trouvé !");
        }
    }

    /**
     * @throws Exception
     */
    public function findById(int $id): ?User
    {
        $row = $this->fetchById($id);
        if (!empty($row)) {
            $user = new User();
            $user->setProperties($row);
            return $user;
        } else {
            throw new Exception("Aucun utilisateur n'a été trouvé !");
        }
    }

    /**
     * @throws Exception
     */
    public function findBy(array $criteria): array
    {
        $rows = $this->fetchBy($criteria);
        $users = [];
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $user = new User();
                $user->setProperties($row);
                $users[] = $user;
            }
            return $users;
        } else {
            throw new Exception("Aucun utilisateur n'a été trouvé !");
        }
    }

    /**
     * @throws Exception
     */
    public function findOneBy(array $criteria): ?User
    {
        $row = $this->fetchOneBy($criteria);
        if (!empty($row)) {
            $user = new User();
            $user->setProperties($row);
            return $user;
        } else {
            throw new Exception("Aucun utilisateur n'a été trouvé !");
        }
    }

    /**
     * @throws Exception
     */
    public function add(User $user)
    {
        $this->new($user);
    }

    protected function getTableName(): string
    {
        return 'user';
    }
}