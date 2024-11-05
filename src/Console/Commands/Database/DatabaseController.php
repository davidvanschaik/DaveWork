<?php

namespace Src\Console\Commands\Database;

use Src\Helpers\CLIHelper as CLI;
use Src\Providers\DatabaseServiceProvider as DB;

require 'config/database.php';

class DatabaseController
{
    protected function getMigrations(): array
    {
        foreach (glob('database/Migrations/*.php') as $migration) {
            $migrationClass[] = pathinfo($migration, PATHINFO_FILENAME);
        }
        return $migrationClass ?? [];
    }

    protected function tableExist(array $migrations, bool $bool) : array
    {
        $tables = [];

        foreach ($migrations as $migration) {
            $table = str_replace('Migration', '', $migration);
            if (DB::tableExists($table) == $bool) {
                $tables[] = $table;
            }
        }
        return $tables;
    }

    protected function validateTables(array $tables, string $command): void
    {
        if (empty($tables)) {
            echo 'Nothing to ' . $command . PHP_EOL;
            exit;
        }
    }

    protected function executeMigrations(array $migrationClass, string $func): void
    {
        foreach ($migrationClass as $migration) {
            $migrationClass = "Database\\Migrations\\" . $migration;
            $time = $this->runMigration($migrationClass, $func);
            $this->showOutput($time, $migration);
        }
    }

    private function runMigration(string $class, string $function): string
    {
        $startTime = microtime('true');
        (new $class())->$function(DB::get());
        $endTime = microtime(true);
        return number_format(($endTime - $startTime) * 1000, 2);
    }

    private function showOutput(string $time, $migration): void
    {
        echo str_pad($migration, 150 - strlen($time . 'ms DONE'), '.');
        echo $time . 'ms ' . CLI::GREEN . 'DONE' . CLI::RESET . PHP_EOL;
    }
}