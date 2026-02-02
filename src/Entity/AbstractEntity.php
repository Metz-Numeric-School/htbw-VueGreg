<?php
namespace App\Entity;

abstract class AbstractEntity
{
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    protected static array $fillable = [];

    public static function hydrate(array $data): self
    {
        $entity = new static();
        foreach ($data as $key => $value) {
            if (!in_array($key, static::$fillable)) {
                continue;
            }
            $method = 'set' . ucfirst($key);
            if (method_exists($entity, $method)) {
                $entity->$method($value);
            }
        }
        return $entity;
    }

}