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

    public function handleErrors(): bool
    {
        $errors = $this->checkIfErrorIsSet();

        if (! empty($errors)) {
            $this->store($errors);
            return false;
        }
        return true;
    }

    public function checkIfErrorIsSet(): array
    {
        $errors = [];
        foreach ($this->errors as $error) {
            if (is_string($error)) {
                $errors[] = $error;
            }
        }
        return $errors;
    }
}