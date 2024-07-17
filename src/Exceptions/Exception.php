<?php

declare(strict_types=1);

namespace Src\Exceptions;

abstract class Exception
{

    abstract function set(string $key, string $message);

    abstract function get();
}
