<?php

namespace Src\Console\Commands\Make;

use Src\Console\Response as CLI;

class MakeFileController
{
    protected string $name;
    protected string $type;
    protected string $dir;

    protected function validate(string $type, string $name): void
    {
        $this->type = $type;
        $this->name = $name;
        $this->dir = $this->getDirectory();

        $this->typeExist();
        $this->fileExist($this->dir, $this->name);
    }

    protected function typeExist(): void
    {
        if (! in_array($this->type, ['controller', 'migration', 'middleware'])) {
            CLI::error();
            exit;
        }
    }

    protected function fileExist(string $dir, string $name): void
    {
        if (file_exists($dir . $name . '.php') || $dir == $name) {
            echo CLI::block() . CLI::echo('RED', " File already exists. \n");
            exit;
        }
    }

    protected function getDirectory(): string
    {
        return match ($this->type) {
            'controller' => "app/Controllers/",
            'middleware' => 'app/Middleware/',
            'migration' => 'database/Migrations/',
        };
    }

    protected function getContent(): array
    {
        $name = $this->name;
        $namespace = ucfirst(substr_replace(implode('\\', explode('/', $this->dir)), '', -1));
        $tableName = strtolower(str_replace('Migration', '', $name)) . 's';

        return compact( 'namespace', 'name', 'tableName');
    }

    protected function generateFile(): string
    {
        ob_start();
        extract($this->getContent(), \EXTR_SKIP);
        include __DIR__ . '/Templates/' . ucfirst($this->type) . '.php';
        return ob_get_clean();
    }

    protected function createFile(string $file): void
    {
        $path = $this->checkIfMigration($this->dir, $this->name);
        file_put_contents($path, $file);

        echo CLI::block() . CLI::echo('GREEN', ' ' . ucfirst($this->type) . " [$path] successfully created. \n");
    }

    private function checkIfMigration(string $path, string $fileName): string
    {
        if ($path == 'database/Migrations/') {
            $migrations = glob('database/Migrations/*.php');

            foreach ($migrations as $migration) {
                $this->fileExist(substr($migration, 24, -4), $fileName);
            }
            $fileName = '00' . count($migrations) + 1 . "_{$fileName}";
        }
        return $path . $fileName . '.php';
    }
}