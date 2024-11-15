<?php

namespace Src\Console\Commands\Database\Service;

use Src\Console\Response as CLI;
use Src\Core\App;
use Src\Providers\DatabaseServiceProvider as DB;

require __DIR__ . '/../../../../Helpers/helpers.php';

class DatabaseService extends MigrationService
{
    protected function executeMigrations(
        array $migrations,
        array $tables,
        string $func,
        string $message
    ): void
    {
        echo CLI::block() . " $message migrations. \n \n";
        $this->setInstance();
        $this->requireFile($this->migrationsFile($migrations, $tables), $func);
    }

    protected function requireFile(array $migrations, string $func): void
    {
        foreach ($migrations as $file) {
            require_once "database/Migrations/{$file}.php";
        }
        $this->runMigration($migrations, $func);
    }

    private function runMigration(array $migrations, string $func): void
    {
        array_map(function ($file, $class) use ($func) {
            $time = $this->callFunction($class, $func);
            $this->showOutput($time, $file);
        }, $migrations, App::getInstance()->resolve('MigrationRegistration')->classes);
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