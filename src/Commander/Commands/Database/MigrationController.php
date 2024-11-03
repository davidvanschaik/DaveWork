<?php

namespace Src\Commander\Commands\Database;

use Src\Helpers\CLIHelper as CLI;
use Src\Providers\DatabaseServiceProvider as DB;

class MigrationController
{
    private string $arg;
    private string $output;
    private string $function;

    public function __construct(string $arg)
    {
        $this->arg = $arg;
        $this->output = $this->arg == 'migrate' ? 'Running' : 'Rolling back';
        $this->function = $this->arg == 'migrate' ? 'run' : 'down';
    }

    public function run(): void
    {
        $migrations = $this->getMigrations();
        $this->checkIfTableExist($migrations);
    }

    private function getMigrations(): array
    {
        $migrationPath = glob('database/Migrations/*.php');
        $migrationClass = [];

        foreach ($migrationPath as $migration) {
            $migrationClass[] = pathinfo($migration, PATHINFO_FILENAME);
        }
        return $migrationClass;
    }

    private function checkIfTableExist(array $migrations): void
    {
        $tables = [];
        $bool = $this->arg != 'migrate';

        foreach ($migrations as $migration) {
            $table = str_replace('Migration', '', $migration);
            if (DB::tableExists($table) == $bool) {
                $tables[] = $table;
            }
        }
        $this->validateMigrations($tables);
    }

    private function validateMigrations(array $tables): void
    {
        if (empty($tables)) {
            echo 'Nothing to ' . $this->arg . PHP_EOL;
            return;
        }
        $this->executeMigrations($tables);
    }

    private function executeMigrations(array $tables): void
    {
        echo "$this->output migrations" . PHP_EOL;

        foreach ($tables as $migration) {
            $migrationClass = "Database\\Migrations\\" . $migration . 'Migration';
            $time = $this->callFunction($migrationClass);
            $this->interfaceOutput($time, $migration);
        }
    }

    private function callFunction(string $migrationClass): string
    {
        $function = $this->function;
        $startTime = microtime('true');
        (new $migrationClass())->$function(DB::get());
        $endTime = microtime(true);
        return number_format(($endTime - $startTime) * 1000, 2);
    }

    private function interfaceOutput(float $time, string $migration): void
    {
        echo str_pad($migration, 150 - strlen($time . 'ms DONE'), '.');
        echo $time . 'ms  ' . CLI::GREEN . 'DONE' . CLI::RESET . PHP_EOL;
    }
}