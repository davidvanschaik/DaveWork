<?php

namespace Src\Console\Commands\Database;

use Database\Seeders\DatabaseSeeder as DB;
use Src\Console\Commands\Command;

class Seed implements Command
{
    private array $arg;

    public function __construct(array $arg)
    {
        $this->arg = $arg;
    }

    public function setCommand(): void
    {
        DB::run();
        echo 'Seeding database.' . PHP_EOL;
    }
}