<?php

declare(strict_types=1);

namespace Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Src\Interfaces\Migration;

class LikeMigration implements Migration
{
    public static function run(Builder $schema): void
    {
        $schema->create('likes', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id');
            $table->foreignId('post_id');
            $table->timestamps();
        });

    }

    public static function down(Builder $schema): void
    {
        $schema->dropIfExists('likes');
    }
}
