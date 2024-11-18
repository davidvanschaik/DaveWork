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

    public function store(array $error): false
    {
        $session = App::getInstance()->resolve('session');
        $session->set('errors', $error);
        return false;
    }

    public function handleErrors(): bool
    {
        $errors = $this->checkIfErrorIsSet();
        return empty($errors) || $this->store($errors);
    }

    public function checkIfErrorIsSet(): array
    {
        return array_values(array_filter($this->errors, 'is_string'));
    }
}