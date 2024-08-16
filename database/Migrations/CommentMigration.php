<?php

declare(strict_types=1);

namespace Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Src\Handlers\ConnectionHandler;
use Src\Interfaces\Migration;

class CommentMigration implements Migration
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