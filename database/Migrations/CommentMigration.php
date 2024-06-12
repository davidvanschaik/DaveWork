<?php

declare(strict_types=1);

namespace Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use src\handlers\ConnectionHandler;
use Src\Interfaces\MigrationInterface;

class CommentMigration implements MigrationInterface
{
    public static function run(ConnectionHandler $connection): void
    {
        $connection->getSchema()->create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->foreignId('user_id');
            $table->foreignId('post_id');
            $table->timestamps();
        });
    }

    public static function down(ConnectionHandler $connection): void
    {
        $connection->getSchema()->dropIfExists('comments');
    }
}
