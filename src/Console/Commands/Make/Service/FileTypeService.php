<?php

namespace Src\Console\Commands\Make\Service;

use Src\Console\Response as CLI;

class FileTypeService extends CreateFileService
{
    protected array $types;
    protected array $names;
    protected array $directories;

    protected function validate(string $type, string $name, string $related): void
    {
        $this->names = [$name];
        $this->types = [$type];
        $this->getRelatedTypes($related);
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

    protected function validateDirectory(): void
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
            $function = $type == 'migration' ? 'migrationClassExist' : 'fileExist';
            $this->$function($this->directories[$key], $this->names[$key], $type, $key);
        }, $this->types, array_keys($this->types));
    }

    protected function fileExist(string $dir, string $name, string $type, int $key): void
    {
        if (file_exists($dir . $name . '.php') || $dir == $name) {
            CLI::invalidCommand(" " . ucfirst($type) . " already exists.");
            exit;
        }
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

    private function migrationClassExist(string $path, string $fileName, string $type, int $key): void
    {
        if ($path == 'database/Migrations/') {
            $migrations = glob('database/Migrations/*.php');

            foreach ($migrations as $migration) {
                $this->fileExist(substr($migration, 24, -4), $fileName, $type, $key);
            }
            $this->names[$key] = '00' . count($migrations) + 1 . "_{$fileName}";
        }
    }
}
