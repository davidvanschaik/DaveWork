<?php

namespace Src\Console\Commands\Database;

use Database\Seeders\DatabaseSeeder as DB;
use Src\Console\Response as CLI;

class Seed
{
    public function __invoke(): void
    {
        DB::run();
        echo CLI::block() . " Seeding database. \n";
    }
}