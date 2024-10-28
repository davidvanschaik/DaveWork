<?php

declare(strict_types=1);

namespace Src\Handlers;

use Src\Core\App;

class ErrorHandler
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