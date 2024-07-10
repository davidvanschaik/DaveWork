<?php

declare(strict_types=1);

namespace Src\Handlers;

class ErrorHandler
{
    protected array $errors;

    public function setErrors(string $key, string $message): void
    {
        $this->errors[$key] = $message;
    }

    public function getErrors(string $key): string
    {
        return $this->errors[$key];
    }
}