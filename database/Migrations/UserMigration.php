<?php

declare(strict_types=1);

namespace Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Src\Handlers\ConnectionHandler;
use Src\Interfaces\Migration;

class UserMigration implements Migration
{
    public static function run(ConnectionHandler $connection): void
    {
        $connection->getSchema()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('email');
            $table->string('password');
            $table->string('phone');
            $table->timestamps();
        });
    }

    public static function down(ConnectionHandler $connection): void
    {
        $connection->getSchema()->dropIfExists('users');
    }
}
