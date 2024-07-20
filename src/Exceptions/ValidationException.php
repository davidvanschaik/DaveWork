<?php

declare(strict_types=1);

namespace Src\Exceptions;

use Src\Core\App;

class ValidationException
{
    public array $errors;

    public function set(string $key, array $message): void
    {
        $this->errors[$key] = $message;
    }

    public function store($errors): void
    {
        $session = App::getInstance()->resolve('session');
        $session->set('errors', $errors);
    }
}