<?php

namespace Src\Console\Commands\Database;

use Database\Seeders\DatabaseSeeder as DB;
use Src\Console\Commands\Command;
use Src\Console\Response as CLI;

class Seed implements Command
{
    public function setCommand(): void
    {
        DB::run();
        echo CLI::block() . " Seeding database. \n";
    }
}