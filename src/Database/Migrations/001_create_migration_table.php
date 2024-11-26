<?php

declare(strict_types=1);

namespace Src\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Src\Abstracts\Migration;

return new class extends Migration
{
    public bool $silent = true;

    public function run(Builder $schema): void
    {
        $schema->create('migrations', function (Blueprint $table) {
            $table->id();
            $table->string('migration');
            $table->string('batch');
        });
    }

    public function down(Builder $schema): void
    {
        $schema->dropIfExists('migrations');
    }
};
