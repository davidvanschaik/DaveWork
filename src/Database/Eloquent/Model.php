<?php

namespace Src\Database\Eloquent;

use Illuminate\Database\Connection;

abstract class Model
{
    protected array $attributes;
    protected string $table;

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->table = strtolower(class_basename(static::class));
    }

    public static function factory(): Factory
    {
        $factory = "\\Database\\Factories\\" . class_basename(static::class) . "Factory";

        if (! class_exists($factory)) {
            dd("Factory for " . static::class . " not found." . PHP_EOL);
            exit;
        }
        return new $factory();
    }

    public function save(Connection $schema): void
    {
        $schema->table($this->table)->insert($this->attributes);
    }
}