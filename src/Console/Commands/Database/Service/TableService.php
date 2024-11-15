<?php

namespace Src\Console\Commands\Database\Service;

use Src\Console\Response as CLI;
use Src\Providers\DatabaseServiceProvider as DB;

class TableService
{
    protected function tableExist(array $migrations) : array
    {
        return array_filter($migrations, function ($migration) {
            if (DB::tableExists($this->getTable($migration)) == $this->bool) {
                return $migration;
            }
        });
    }

    protected function getTable(string $migration): string
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
}