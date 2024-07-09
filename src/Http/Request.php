<?php

declare(strict_types=1);

namespace Src\Http;

class Request
{
    private static ?Request $instance = null;
    public readonly object $parameters;
    public static array $errors;
    public static function getInstance(): Request
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function uri()
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

    public function setErrors(string $key, string $value): void
        {
            self::$errors[$key] = $value;
        }

    public function getErrors()
    {
        if (isset(self::$errors)) {
            return self::$errors;
        }
    }

    public function setParameters(array $parameters): void
    {
        $this->parameters = (object) $parameters;
    }
}