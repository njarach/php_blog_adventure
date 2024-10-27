<?php

namespace src\Model;

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

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return get_object_vars($this);
    }

    /**
     * @param array $data
     * @return void
     */
    public function setProperties(array $data): void
    {
        foreach ($data as $key => $value) {
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
}