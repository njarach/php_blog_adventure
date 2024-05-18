<?php

namespace src\Model;

interface EntityInterface
{
    public function getId(): int;
    public function setId(int $id);
}