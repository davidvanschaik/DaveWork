<?php

declare(strict_types=1);

namespace Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Src\Interfaces\Migration;

class ProfileMigration implements Migration
{
    public function run(Builder $schema): void
    {
        $schema->create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('bio_info');

//            $table->boolean('verified');
//            $table->string('bio_name');
//            $table->string('profile_picture');
//            $table->bigInteger('followers');
//            $table->bigInteger('following');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });

    }

    public function down(Builder $schema): void
    {
        $schema->dropIfExists('profiles');
    }
}
