<?php

namespace Src\Console\Commands\Make;

use Src\Console\Validator;
use Src\Helpers\CLIHelper as CLI;

class MakeFileController
{
    protected string $dir;

    protected function typeExist(string $fileType): void
    {
        if (! in_array($fileType, ['controller', 'migration', 'middleware'])) {
            Validator::handleError();
            exit;
        }
    }
    protected function fileExist(string $fileName, string $dir): void
    {
        if (file_exists($dir . $fileName . '.php')) {
            echo CLI::RED . 'File already exists' . CLI::RESET . PHP_EOL;
            exit;
        }
    }
    protected function getDirectory(string $type): string
    {
        return match ($type) {
            'controller' => "app/Controllers/",
            'middleware' => 'app/Middleware/',
            'migration' => 'database/Migrations/',
        };
    }

    protected function getContent(string $dir, string $className): array
    {
        $namespace = ucfirst(substr_replace(implode('\\', explode('/', $dir)), '', -1));
        $tableName = strtolower(str_replace('Migration', '', $className));

        return compact( 'namespace', 'className', 'tableName');
    }

    protected function generateFile(array $fileContent, string $fileType): string
    {
        ob_start();
        extract($fileContent, \EXTR_SKIP);
        include __DIR__ . '/Templates/' . ucfirst($fileType) . '.php';
        return ob_get_clean();
    }

    protected function createFile(string $file, string $path, string $fileType): void
    {
        file_put_contents($path, $file);

        echo CLI::echo('GREEN', ucfirst($fileType) . " [$path] successfully created");
    }
}