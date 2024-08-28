<?php

declare(strict_types=1);

namespace Src\Exceptions;

use Src\Core\App;

class ValidationException
{
    public array $errors;

    public function set(string $key, mixed $message): void
    {
        $this->errors[$key] = $message;
    }

    public function store(array $error): void
    {
        $session = App::getInstance()->resolve('session');
        $session->set('errors', $error);
    }

    public function checkIfErrorsSet(): bool
    {
        return isset($this->errors);
    }
}