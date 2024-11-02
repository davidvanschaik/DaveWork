<?php

declare(strict_types=1);

namespace Src\Interfaces;

use Illuminate\Database\Schema\Builder;
use Src\Handlers\ConnectionHandler;

interface Migration
{
    public static function run(Builder $schema);

    public static function down(Builder $schema);

}