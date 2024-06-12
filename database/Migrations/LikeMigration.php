<?php

declare(strict_types=1);

namespace Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use src\handlers\ConnectionHandler;
use Src\Interfaces\MigrationInterface;

class LikeMigration implements MigrationInterface
{
    public static function run(ConnectionHandler $connection): void
    {
        $connection->getSchema()->create('likes', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id');
            $table->foreignId('post_id');
            $table->timestamps();
        });

    }

    public static function down(ConnectionHandler $connection): void
    {
        $connection->getSchema()->dropIfExists('likes');
    }
}
