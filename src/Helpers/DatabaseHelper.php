<?php

namespace Src\Helpers;

use Src\Database\Connections\Database as DB;
use Src\Database\Repositories\MigrationRepository;

class DatabaseHelper
{
    private static bool $bool;

    public static function validateMigrations(bool $bool): array
    {
        self::$bool = $bool;
        return self::pendingMigrations(self::getExecutedMigrations(), self::collectMigrations());
    }

    private static function pendingMigrations(array $executed, array $all): array
    {
        $migrations = array_map(function ($dir) use ($all, $executed) {
            return array_filter($all[$dir], function ($migration) use ($executed) {
                return in_array($migration, $executed) == self::$bool;
            });
        }, array_keys($all));

        return array_combine(array_keys($all), $migrations);
    }

    private static function getExecutedMigrations(): array
    {
        if (self::tableExists('migrations')) {
            return array_map(function ($executed) {
                return $executed->migration;
            }, (new MigrationRepository())->getAll());
        }
        return [];
    }

    public static function tableExists(string $table): bool
    {
        return DB::tableExist($table);
    }

    private static function collectMigrations(): array
    {
        return array_reduce(self::returnMigrationDirectories(), function ($migrations, $dir) {
            $migrations[$dir] = self::fetchMigrations($dir);
            return $migrations;
        }, []);
    }

    private static function returnMigrationDirectories(): array
    {
        if (self::tableExists('migrations') == self::$bool && !self::$bool) {
            return ['src/Database', 'database'];
        }
        return ['database'];
    }

    private static function fetchMigrations(string $dir): array
    {
        return self::sortMigrations(array_map(function ($migration) {
            return pathInfo($migration, PATHINFO_FILENAME);
        }, glob("$dir/Migrations/*")));
    }

    private static function sortMigrations(array $migrations): array
    {
        return !self::$bool ? $migrations : array_reverse($migrations);
    }

    public static function dropTables(): void
    {
        DB::dropTables();
    }
}