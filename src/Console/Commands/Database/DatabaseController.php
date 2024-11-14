<?php

namespace Src\Console\Commands\Database;

use Src\Console\Response as CLI;
use Src\Core\App;
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
            echo CLI::block() . " Nothing to $command. \n \n";
            exit;
        }
    }

    protected function executeMigrations(array $migrationClass, string $func, string $message): void
    {
        echo CLI::block() . " $message migrations. \n \n";
        $this->setInstance();
        $this->requireFile($migrationClass, $func);
    }

    private function setInstance(): void
    {
        App::getInstance()->singleton('MigrationRegistration', function () {
            return new class {
                public array $classes = [];
            };
        });
    }

    private function requireFile(array $migrations, string $func): void
    {
        foreach ($migrations as $file) {
            require_once "database/Migrations/{$file}.php";
        }
        $this->runMigration($migrations, $func);
    }

    private function runMigration(array $migration, string $func): void
    {
        array_map(function ($file, $class) use ($func) {
            $time = $this->callFunction($class, $func);
            $this->showOutput($time, $file);
        }, $migration, App::getInstance()->resolve('MigrationRegistration')->classes);
    }

    private function callFunction(object $class, string $function): string
    {
        $startTime = microtime('true');
        $class->$function(DB::get());
        $endTime = microtime(true);
        return number_format(($endTime - $startTime) * 1000, 2);
    }

    private function showOutput(string $time, $migration): void
    {
        $dots = str_repeat('.', 150 - strlen("$migration {$time}ms DONE"));
        echo "    $migration " . CLI::echo('GRAY', "$dots {$time}ms ");
        echo CLI::echo('GREEN', "DONE \n");
    }
}