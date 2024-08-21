<?php

namespace src\Repository;

interface RepositoryInterface
{
    public function findAll(): ?array;
    public function findById(int $id): ?object;
    public function findBy(array $criteria): ?array;
    public function findOneBy(array $criteria): ?object;

}