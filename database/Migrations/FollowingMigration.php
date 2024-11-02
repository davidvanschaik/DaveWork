<?php

declare(strict_types=1);

namespace Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Src\Interfaces\Migration;

class FollowingMigration implements Migration
{
    public function run(Builder $schema): void
    {
        $schema->create('following', function (Blueprint $table) {
            $table->foreignId('user_id');
            $table->foreignId('following_id');
            $table->timestamps();
        });

    }

    public static function down(Builder $schema): void
    {
        $schema->dropIfExists('following');
    }

}