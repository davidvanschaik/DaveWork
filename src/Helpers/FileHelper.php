<?php

namespace Src\Helpers;

use Src\Console\Response as CLI;
use Src\Helpers\FileHelper as Helper;

class FileHelper
{
    private static string $dir;
    private static string $name;
    private static string $type;

    public static function fileExist(string $dir, string $name, string $type = ''): void
    {
        if (file_exists($dir . $name . '.php') || $dir == $name) {
            CLI::invalidCommand(" " . ucfirst($type) . " already exists.");
            exit;
        }
    }

    public static function makeFile(array $name, array $types, array $dir): void
    {
        array_map(function ($name, $dir, $type) {
            self::$type = $type;
            self::$name = $name;
            self::$dir = $dir;

            self::createFile($dir, $name, self::generateFile(), $type);
        }, $name, $dir, $types);
    }

    public static function generateFile(): string
    {
        ob_start();
        extract(self::getContent(), \EXTR_SKIP);
        include __DIR__ . '/../Console/Templates/' . ucfirst(self::$type) . '.php';
        return ob_get_clean();
    }

    public static function getContent(): array
    {
        $name = self::$name;
        $namespace = Helper::dirToNamespace(self::$dir);
        $tableName = strtolower(str_replace('Migration', '', $name)) . 's';

        return compact( 'namespace', 'name', 'tableName');
    }

    public static function createFile(string $dir, string $name, string $file, string $type): void
    {
        $path = "$dir$name.php";
        file_put_contents($path, $file);

        echo CLI::block() . CLI::echo('GREEN', ' ' . ucfirst($type) . " [$path] successfully created. \n \n");
    }

    public static function dirToNamespace(string $dir): string
    {
        return ucfirst(substr_replace(implode('\\', explode('/', $dir)), '', -1));
    }
}