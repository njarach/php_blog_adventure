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

    public function getProperties(): array
    {
        return get_object_vars($this);
    }

    public function setProperties(array $data): void
    {
        foreach ($data as $key => $value) {
            // Convert snake_case to camelCase for method names
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
}