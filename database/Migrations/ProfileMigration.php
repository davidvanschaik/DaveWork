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
        $schema->create('profile', function (Blueprint $table) {
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

    public static function down(Builder $schema): void
    {
        $schema->dropIfExists('profile');
    }
}
