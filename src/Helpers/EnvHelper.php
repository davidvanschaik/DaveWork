<?php

namespace Src\Helpers;

use Dotenv\Dotenv;

class EnvHelper
{
    public static function load(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
    }
}