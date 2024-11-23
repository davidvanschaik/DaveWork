<?php

namespace Src\Console\Services;

use Src\Console\Response as CLI;
use Src\Core\App;
use Src\Database\Repositories\MigrationRepository;
use Src\Helpers\DatabaseHelper as Helper;
use Src\Providers\DatabaseServiceProvider as DB;

class DatabaseService
{
    public function __construct()
    {
        App::getInstance()->singleton('MigrationRegistration', function () {
            return new class {
                public array $classes = [];
            };
        });
    }

    public function startMigrations(array $migrations, array $tables, string $message): object
    {
        echo CLI::block() . " $message migrations. \n \n";
        return $this->requireFile(Helper::migrationsFile($migrations, $tables));
    }

    public function requireFile(array $migrations, string $path = 'database'): object
    {
        foreach ($migrations as $file) {
            require_once "$path/Migrations/$file.php";
        }
        return $this;
    }

    public function runMigrationWithoutOutput(array $migrations, string $func)
    {
//        var_dump(App::getInstance()->resolve('MigrationRegistration')->classes);
        array_map(function ($file, $class) use ($func) {
            $time = $this->callFunction($class, $func);
//            MigrationRepository::insert($file);
        }, $migrations, App::getInstance()->resolve('MigrationRegistration')->classes);
    }

    public function runMigrationWithOutput(array $migrations, string $func): void
    {
        array_map(function ($file, $class) use ($func) {
            $time = $this->callFunction($class, $func, DB::get());
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

    private function showOutput(string $time, string $migration): void
    {
        $dots = str_repeat('.', 150 - strlen("$migration {$time}ms DONE"));
        echo "    $migration " . CLI::echo('GRAY', "$dots {$time}ms ");
        echo CLI::echo('GREEN', "DONE \n");
    }
}