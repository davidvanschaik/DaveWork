<?php

namespace Src\Commander\Commands\Make;

class MakeController
{
    public string $directory;

    public function run(string $directory, string $fileName): void
    {
        $path = match ($this->directory = strtolower($directory)) {
            'controller' => "app/Controllers/",
            'model' => "app/Models/",
            'migration' => "database/Migrations/",
            'view' => 'resources/views/',
            default => null
        };
        $this->createFile($path, $fileName);
    }

    private function createFile(string $path, string $fileName): void
    {
        $filename = $path . $fileName . '.php';
        fopen($filename, 'x+');
        echo ucfirst($this->directory) . " [$filename] created successfully" . PHP_EOL;
    }
}