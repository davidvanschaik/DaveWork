<?php

namespace Src\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Src\Abstracts\Migration;

return new class extends Migration
{
    protected bool $silent = true;

    public function run(Builder $schema): void
    {
        $schema->create('sessions', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('ip_address');
            $table->string('user_agent');
            $table->string('payload');
            $table->string('last_activity');
        });
    }

    public function down(Builder $schema): void
    {
        $schema->dropIfExists('sessions');
    }
};