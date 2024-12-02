<?php

namespace Src\Console\Commands\Database;

use Database\Seeders\DatabaseSeeder as DB;
use Src\Console\Response as CLI;
use Src\Contracts\Command;

class SeedCommand implements Command
{
    public function __invoke(): void
    {
        DB::run();
        echo CLI::block() . " Seeding database. \n";
    }
}