<?php

namespace Src\Helpers;

use Src\Console\Response as CLI;
use Src\Providers\DatabaseServiceProvider as DB;

class DatabaseHelper
{
    private static bool $bool;

    public static function getMigrations(int $bool, string $path = 'database'): array
    {
        self::$bool = $bool;
        return self::sortMigrations(array_map(function ($migration) {
            return pathInfo($migration, PATHINFO_FILENAME);
        }, glob("$path/Migrations/*")), $bool);
    }

    private static function sortMigrations(array $migrations, bool $bool): array
    {
        return !$bool ? $migrations : array_reverse($migrations);
    }

    public static function migrationsFile(array $migrations, array $tables): array
    {
        return array_map(function ($key) use ($migrations) {
            return $migrations[$key];
        }, array_keys($tables));
    }

    public static function tableExist(array $migrations): array
    {
        return array_filter($migrations, function ($migration) {
            if (DB::tableExists(self::setTableName($migration)) == self::$bool) {
                return $migration;
            }
        });
    }

    public static function setTableName(string $migration): string
    {
        $table = explode('_', $migration);
        return $table[2] . 's';
    }

    public static function validateTables(array $tables, string $command): void
    {
        if (empty($tables)) {
            echo CLI::block() . " Nothing to $command. \n \n";
            exit;
        }
    }
}