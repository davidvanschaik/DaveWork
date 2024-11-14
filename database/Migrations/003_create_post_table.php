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
        $schema->create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->text('body');
            $table->foreignId('profile_id');
//            $table->text('info');
            $table->timestamps();

            $table->foreign('profile_id')->references('id')->on('profiles');
        });

    }

    public function down(Builder $schema): void
    {
        $schema->dropIfExists('posts');
    }
};
