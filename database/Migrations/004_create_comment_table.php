<?php

declare(strict_types=1);

namespace Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Src\Abstracts\Migration;

return new class extends Migration
{
    public function run(Builder $schema): void
    {
        $schema->create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->foreignId('user_id');
            $table->foreignId('post_id');
            $table->timestamps();
        });
    }

    public function down(Builder $schema): void
    {
        $schema->dropIfExists('comments');
    }
};
