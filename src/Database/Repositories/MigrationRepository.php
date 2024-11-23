<?php

namespace Src\Database\Repositories;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Src\Providers\DatabaseServiceProvider as DB;

class MigrationRepository
{
    private Builder $table;

    public function __construct()
    {
        $this->table = DB::get();
    }

    public function insert(string $table)
    {
        $this->connection->table($table, function (Blueprint $table) {

        });
    }

    private function getMigrations()
    {
        $this->connection
    }
}