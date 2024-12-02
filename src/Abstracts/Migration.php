<?php

namespace Src\Abstracts;

use Src\Contracts\Migration as MigrationInterface;
use Src\Core\App;

abstract class Migration implements MigrationInterface
{
    public bool $silent = false;

    public function __construct()
    {
        App::getInstance()->resolve('MigrationRegistration')->classes[] = $this;
    }
}