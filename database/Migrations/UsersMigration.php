<?php

declare(strict_types=1);

namespace Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Src\Interfaces\Migration;

class UsersMigration implements Migration
{
    public function run(Builder $schema): void
    {
        $schema->create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('email');
            $table->string('password');
            $table->string('phone');
            $table->timestamps();
        });
    }

    public static function down(Builder $schema): void
    {
        $schema->dropIfExists('user');
    }
}
