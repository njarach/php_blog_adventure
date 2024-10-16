<?php

namespace src\Repository;

use Exception;
use src\model\User;

class UserRepository extends AbstractRepository
{
    /**
     * @return string
     */
    protected function getTableName(): string
    {
        return 'user';
    }

    /**
     * @throws Exception
     */
    public function add(User $user)
    {
        $this->new($user);
    }

    /**
     * @throws Exception
     */
    public function findAll(): array
    {
        $rows = $this->fetchAll();
        return $this->getUsers($rows);

    }

    /**
     * @throws Exception
     */
    public function findById(int $id): User
    {
        $row = $this->fetchById($id);
        return $this->getUser($row);
    }

    /**
     * @throws Exception
     */
    public function findBy(array $criteria): array
    {
        $rows = $this->fetchBy($criteria);
        return $this->getUsers($rows);
    }

    /**
     * @throws Exception
     */
    public function findOneBy(array $criteria): ?User
    {
        $row = $this->fetchOneBy($criteria);
        return $this->getUser($row);
    }

    /**
     * @param bool|array $rows
     * @return array
     */
    private function getUsers(bool|array $rows): array
    {
        if (count($rows)) {
            $users = [];
            foreach ($rows as $row) {
                $user = $this->createUserObject($row);
                $users[] = $user;
            }
            return $users;
        }
        return [];
    }

    /**
     * @param bool|array $row
     * @return User
     * @throws Exception
     */
    private function getUser(bool|array $row): User
    {
        if (!empty($row)) {
            return $this->createUserObject($row);
        } else {
            throw new Exception("Aucun utilisateur n'a été trouvé !");
        }
    }

    /**
     * @param mixed $row
     * @return User
     */
    private function createUserObject(mixed $row): User
    {
        $user = new User();
        $user->setProperties($row);
        return $user;
    }
}