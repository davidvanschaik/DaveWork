<?php

namespace Src\Database\Repositories;

use Illuminate\Database\Query\Builder;
use Src\Contracts\Repository;
use Src\Database\Connections\Database as DB;
use Src\Helpers\DatabaseHelper as Helper;

class MigrationRepository implements Repository
{
    private static Builder $table;
    private int $batch;

    public function __construct()
    {
        self::$table = DB::table('migrations');
        $this->batch = $this->last();
    }

    public function insert(mixed $info): void
    {
        self::$table->insert([
            'migration' => $info,
            'batch' => $this->batch
        ]);
    }

    public function delete(): void
    {
        self::$table->delete();
    }

    public function getAll(): array
    {
        return self::$table->get('migration')->toArray();
    }

    public function last(): int
    {
        if (Helper::tableExists('migrations') && self::$table->get('batch')->last() != null) {
            return (int)(self::$table->get('batch')->last())->batch + 1;
        }
        return 1;
    }
}