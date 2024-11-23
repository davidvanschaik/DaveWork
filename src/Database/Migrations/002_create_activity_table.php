<?php

declare(strict_types=1);

namespace Src\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Src\Abstracts\Migration;

return new class extends Migration
{
    protected bool $silent = true;

    public function run(Builder $schema): void
    {
        $schema->create('activitys', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('uri');
            $table->string('request');
            $table->string('method');
            $table->string('response_code');
        });
    }

    public function down(Builder $schema): void
    {
        $schema->dropIfExists('activitys');
    }
};
