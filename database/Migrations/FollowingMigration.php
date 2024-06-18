<?php

declare(strict_types=1);

namespace Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Src\Handlers\ConnectionHandler;
use Src\Interfaces\Migration;

class FollowingMigration implements Migration
{
    public static function run(ConnectionHandler $connection): void
    {
        $connection->getSchema()->create('following', function (Blueprint $table) {
            $table->foreignId('user_id');
            $table->foreignId('following_id');
            $table->timestamps();
        });

    }

    public static function down(ConnectionHandler $connection): void
    {
        $connection->getSchema()->dropIfExists('following');
    }

}