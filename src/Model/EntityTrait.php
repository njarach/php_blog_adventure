<?php

namespace src\model;

trait EntityTrait
{
    protected int $id;

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
// this is actually auto incremented ?

    public function getProperties(): array
    {
        return get_object_vars($this);
    }
}