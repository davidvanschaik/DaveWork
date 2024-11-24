<?php

namespace Src\Helpers;

use Src\Database\Repositories\MigrationRepository;
use Src\Providers\DatabaseServiceProvider as DB;

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
        return DB::get()->hasTable($table);
    }

    private static function collectMigrations(): array
    {
        return array_reduce(self::getDirectories(), function ($migrations, $dir) {
            $migrations[$dir] = self::FetchMigrations($dir);
            return $migrations;
        }, []);
    }

    private static function getDirectories(): array
    {
        if (self::tableExists('migrations') == self::$bool && !self::$bool) {
            return ['src/Database', 'database'];
        }
        return ['database'];
    }

    private static function FetchMigrations(string $dir): array
    {
        return self::sortMigrations(array_map(function ($migration) {
            return pathInfo($migration, PATHINFO_FILENAME);
        }, glob("$dir/Migrations/*")));
    }

    private static function sortMigrations(array $migrations): array
    {
        return !self::$bool ? $migrations : array_reverse($migrations);
    }
}