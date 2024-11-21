<?php

namespace Src\Console\Services;

use Src\Helpers\FileHelper as Helper;

class MakeService
{
    public array $types;
    public array $names;
    public array $directories;

    public function validate(string $type, string $name, string $related): object
    {
        $this->names = [$name];
        $this->types = [$type];
        $this->getRelatedTypes($related);
        return $this;
    }

    private function getRelatedTypes(mixed $related): void
    {
        if (empty($related)) {
            return;
        }

        $relatedTypes = match ($related) {
            'f' => ['factory'],
            'm' => ['migration'],
            'fm', 'mf' => ['migration', 'factory']
        };
        array_push($this->types, ...$relatedTypes);
    }

    public function validateDirectory(): void
    {
        $this->directories = array_map(fn ($type) => $this->getDirectory($type), $this->types);
        $this->relatedFileNames();
        $this->validateFileExist();
    }

    protected function relatedFileNames(): void
    {
        array_map(fn ($type) => $this->setRelatedFileName($type), $this->types);
    }

    private function getDirectory(mixed $type): string | null
    {
        return match ($type) {
            'controller' => "app/Controllers/",
            'middleware' => 'app/Middleware/',
            'model' => 'app/Models/',
            'migration' => 'database/Migrations/',
            'factory' => 'database/Factories/',
            'view' => 'resources/views/layouts'
        };
    }

    public function validateFileExist(): void
    {
        array_map(function ($type, $key) {
            $args = [$this->directories[$key], $this->names[$key], $type, $key];
            $type != 'migration'
                ? Helper::fileExist(...$args)
                : $this->migrationClassExist($this->getDirectory($type), $this->names[$key], $key);
        }, $this->types, array_keys($this->types));
    }

    protected function setRelatedFileName(string $type): void
    {
        if ($type == 'factory' && ! str_contains($this->names[0], 'Factory')) {
            $this->names[] = $this->names[0] . 'Factory';
        }

        if ($type == 'migration' && ! str_contains($this->names[0], 'create')) {
            $this->names[] = 'create_' . strtolower($this->names[0]) . '_table';
        }
    }

    private function migrationClassExist(string $path, string $fileName, int $key): void
    {
        if ($path == 'database/Migrations/') {
            $migrations = glob('database/Migrations/*.php');
            foreach ($migrations as $migration) {
                Helper::fileExist(substr($migration, 24, -4), $fileName);
            }
            $this->names[$key] = '00' . count($migrations) + 1 . "_{$fileName}";
        }
    }
}
