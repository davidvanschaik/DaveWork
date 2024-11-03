<?php

declare(strict_types=1);

namespace Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Src\Interfaces\Migration;

class PostMigration implements Migration
{
    public function run(Builder $schema): void
    {
        $schema->create('post', function (Blueprint $table) {
            $table->increments('id');
            $table->text('body');
            $table->foreignId('user_id');
            $table->text('info');
            $table->timestamps();
        });

    }

    public function down(Builder $schema): void
    {
        $schema->dropIfExists('post');
    }
}
