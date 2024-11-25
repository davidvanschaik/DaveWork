<?php

namespace Src\Abstracts;

use Illuminate\Database\Schema\Builder;
use Src\Core\App;

abstract class Migration
{
    public bool $silent = false;

    public function __construct()
    {
        App::getInstance()->resolve('MigrationRegistration')->classes[] = $this;
    }

    abstract public function run(Builder $schema);

    abstract public function down(Builder $schema);
}