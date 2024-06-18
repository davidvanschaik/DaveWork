<?php

declare(strict_types=1);

namespace Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Src\Handlers\ConnectionHandler;
use Src\Interfaces\Migration;

class PostMigration implements Migration
{
    public static function run(ConnectionHandler $connection): void
    {
        $connection->getSchema()->create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->text('body');
            $table->foreignId('user_id');
            $table->text('info');
            $table->timestamps();
        });

    }

    public static function down(ConnectionHandler $connection): void
    {
        $connection->getSchema()->dropIfExists('posts');
    }
}
