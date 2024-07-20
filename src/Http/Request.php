<?php

declare(strict_types=1);

namespace Src\Http;

readonly class Request
{
    public readonly object $parameters;
    public array $errors;

    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function uri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function QueryParams(): array
    {
        return $_GET;
    }

    public function BodyParams(): array
    {
        return $_POST;
    }

    public function setParameters(array $parameters): void
    {
        $this->parameters = (object) $parameters;
    }

    public function setErrors(array $data): void
    {
        $this->errors = $data ?? [];
    }

    public function getErrors(): array
    {
        return $this->errors ?? [];
    }
}