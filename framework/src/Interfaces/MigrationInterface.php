<?php

declare(strict_types=1);

namespace Src\Interfaces;

use Src\Handlers\ConnectionHandler;

interface MigrationInterface
{
    public static function run(ConnectionHandler $connection);

    public static function down(ConnectionHandler $connection);

}