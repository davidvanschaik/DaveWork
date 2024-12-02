<?php

namespace Src\Console\Services;

use Src\Console\Response as CLI;
use Src\Core\App;
use Src\Database\Connections\Database as DB;
use Src\Database\Repositories\MigrationRepository;

class DatabaseService
{
    private array $migrations;

    public function validateMigrations(string $command, array $migrations): object
    {
        $this->migrations = $migrations;
        array_map(function ($migrations) use ($command) {
            $this->noPendingMigrations($migrations, $command);
        }, $migrations);

        return $this;
    }

    private function noPendingMigrations(array $migrations, string $command): void
    {
        if (empty($migrations)) {
            echo CLI::block() . " Nothing to $command. \n \n";
            exit;
        }
    }

    public function startMigrating(string $message, string $func): void
    {
        echo CLI::block() . " $message migrations. \n \n";
        $this->runMigrations($func);
    }

    public function runMigrations(string $func, $silent = true): void
    {
        array_map(function ($migration, $key) use ($func, $silent) {
            $this->requireFile($key, $func, $silent);
        }, $this->migrations, array_keys($this->migrations));
    }

    private function requireFile(string $key, string $func, bool $silent): void
    {
        $this->setInstance();
        foreach ($this->migrations[$key] as $file) {
            require_once "$key/Migrations/$file.php";
        }
        $this->executeMigration($key, $func, $silent);
    }

    private function setInstance(): void
    {
        App::getInstance()->singleton('MigrationRegistration', function () {
            return new class {
                public array $classes = [];
            };
        });
    }

    private function executeMigration(string $key, string $func, bool $silent): void
    {
        $repo = new MigrationRepository();
        array_map(function ($file, $class) use ($func, $repo, $silent) {
            $time = $this->callFunction($class, $func);
            $this->validateOutput($class, $file, $time, $func, $repo, $silent);
        }, $this->migrations[$key], App::getInstance()->resolve('MigrationRegistration')->classes);
    }

    private function callFunction(mixed $class, string $function): string
    {
        $startTime = microtime('true');
        $class->$function(DB::get());
        $endTime = microtime(true);
        return number_format(($endTime - $startTime) * 1000, 2);
    }

    private function validateOutput(
        object $class,
        string $fileName,
        string $time,
        string $func,
        MigrationRepository $repo,
        bool $silent
    ): void
    {
        $function = $this->migrationFunction($func);
        if (! $class->silent) {
            $repo->$function($fileName);
        }
        if (! $class->silent && $silent) {
            $this->showOutput($time, $fileName);
        }
    }

    private function migrationFunction(string $function): string
    {
        return match ($function) {
            'run' => 'insert',
            'down' => 'delete',
        };
    }

    private function showOutput(string $time, string $migration): void
    {
        $dots = str_repeat('.', 150 - strlen("$migration {$time}ms DONE"));
        echo "    $migration " . CLI::echo('GRAY', "$dots {$time}ms ");
        echo CLI::echo('GREEN', "DONE \n");
    }
}