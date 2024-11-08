<?php

namespace Src\Console\Commands\Database;

use Src\Console\Response as CLI;
use Src\Providers\DatabaseServiceProvider as DB;

class DatabaseController
{
    private bool $bool;

    protected function getMigrations(bool $bool): array
    {
        $this->bool = $bool;

        foreach (glob('database/Migrations/*.php') as $migration) {
            $migrationClass[] = pathinfo($migration, PATHINFO_FILENAME);
        }
        return $this->sortTables($migrationClass, $bool);
    }

    protected function tableExist(array $migrations) : array
    {
        $tables = [];

        foreach ($migrations as $migration) {
            $table = $this->getTable($migration);
            if (DB::tableExists($table) == $this->bool) {
                $tables[] = $table;
            }
        }
        return $tables;
    }

    private function sortTables(array $migrations, bool $bool): array
    {
        return !$bool ? $migrations : array_reverse($migrations);
    }

    private function getTable(string $migration): string
    {
        $table = explode('_', $migration);
        return $table[2] . 's';
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
            require_once "database/Migrations/{$migration}.php";
            $migrationClass = $this->getClassName($migration);
            $time = $this->runMigration($migrationClass, $func);
            $this->showOutput($time, $migration);
        }
    }

    private function getClassName(string $migration): string
    {
        $parts = explode('_', substr($migration, 4));
        return "Database\\Migrations\\" . implode('', array_map('ucfirst', $parts));;
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