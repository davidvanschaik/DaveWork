<?php

declare(strict_types=1);

namespace Src\Contracts;

use Illuminate\Database\Schema\Builder;

interface Migration
{
    public function run(Builder $schema);

    public function down(Builder $schema);
}