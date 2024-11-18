<?php

namespace Src\Console\Commands\Database\Service;

use Src\Core\App;

class MigrationService extends TableService
{
    protected bool $bool;

    protected function getMigrations(bool $bool): array
    {
        $this->bool = $bool;
        return $this->sortMigrations(array_map(function ($migration) {
            return pathInfo($migration, PATHINFO_FILENAME);
        }, glob('database/Migrations/*')),
            $bool
        );
    }

    protected function sortMigrations(array $migrations, bool $bool): array
    {
        return !$bool ? $migrations : array_reverse($migrations);
    }

    protected function setInstance(): void
    {
        App::getInstance()->singleton('MigrationRegistration', function () {
            return new class {
                public array $classes = [];
            };
        });
    }

    protected function migrationsFile(array $migrations, array $tables): array
    {
        return array_map(function ($key) use ($migrations) {
            return $migrations[$key];
        }, array_keys($tables));
    }
}