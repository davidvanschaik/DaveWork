<?php

declare(strict_types=1);

namespace Src\Exceptions;

abstract class Exception
{
    protected array $errors;

    abstract function set(string $key, string $message);

    abstract function get();
}
