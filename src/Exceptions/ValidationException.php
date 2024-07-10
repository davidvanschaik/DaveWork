<?php

declare(strict_types=1);

namespace Src\Exceptions;

class ValidationException
{
    protected array $exceptions = [];
    public function setException(string $key, string $exception): void
    {
        $this->exceptions[$key] = $exception;
    }

    public function getExceptions(): array
    {
        return $this->exceptions;
    }
}