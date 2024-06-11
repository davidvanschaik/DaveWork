<?php

declare(strict_types=1);

namespace Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use src\handlers\ConnectionHandler;
use Src\Interfaces\MigrationInterface;

class ProfileMigration implements MigrationInterface
{
    public static function run(ConnectionHandler $connection): void
    {
        $connection->getSchema()->create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id');
            $table->boolean('verified');
            $table->string('bio_name');
            $table->text('bio_info');
            $table->string('profile_picture');
            $table->bigInteger('followers');
            $table->bigInteger('following');
            $table->timestamps();
        });

    }

    public static function down(ConnectionHandler $connection): void
    {
        $connection->getSchema()->dropIfExists('profiles');
    }
}
