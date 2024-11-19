<?php

namespace Src\Console\Commands\Make\Service;


use Src\Console\Response as CLI;

class CreateFileService
{
    protected string $dir;
    protected string $name;
    protected string $type;

    public function makeFile(array $name, array $types, array $dir): void
    {
        array_map(function ($name, $dir, $type) {
            $this->type = $type;
            $this->name = $name;
            $this->dir = $dir;

            $this->createFile($this->generateFile());
        }, $name, $dir, $types);
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
        include __DIR__ . '/../Templates/' . ucfirst($this->type) . '.php';
        return ob_get_clean();
    }

    protected function createFile(string $file): void
    {
        $path = "$this->dir{$this->name}.php";
        file_put_contents($path, $file);

        echo CLI::block() . CLI::echo('GREEN', ' ' . ucfirst($this->type) . " [$path] successfully created. \n");
    }
}