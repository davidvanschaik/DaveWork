<?php

declare(strict_types=1);

namespace Src\Http;

readonly class Request
{
    public readonly object $parameters;
    public array $errors;

    public function method(): mixed
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function uri(): mixed
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function queryParams(): array
    {
        return $_GET;
    }

    public function bodyParams(): array
    {
        return $_POST;
    }

    public function unsetPost(string $key): void
    {
        unset($_POST[$key]);
    }

    public function unsetGet(string $key): void
    {
        unset($_GET[$key]);
    }

    public function setParameters(array $parameters): void
    {
        $this->parameters = (object)$parameters;
    }

    public function getParameters(array $parameters): object
    {
        return $this->parameters ?? new \stdClass();
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