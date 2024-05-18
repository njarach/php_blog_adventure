<?php

namespace src\repository;

use src\Model\EntityInterface;

interface RepositoryInterface
{
    public function findAll():array;
    public function findById(int $id): ?array;
    public function findBy(array $criteria): array;

}