<?php

declare(strict_types=1);

namespace Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Src\Interfaces\Migration;

class CommentMigration implements Migration
{
    public function run(Builder $schema): void
    {
        $schema->create('comment', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->foreignId('user_id');
            $table->foreignId('post_id');
            $table->timestamps();
        });
    }

    public function down(Builder $schema): void
    {
        $schema->dropIfExists('comment');
    }
}
