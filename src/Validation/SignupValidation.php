<?php

declare(strict_types=1);

namespace Src\Validation;

use Src\Core\App;
use Src\Handlers\ErrorHandler;

class SignupValidation
{
    private array $postData;
    private ErrorHandler $errorHandler;

    public function __construct(array $data)
    {
        $this->postData = $data;
        $this->errorHandler = App::getInstance()->resolve('error');
    }
    
    public function validateCredentials($validationParams): bool
    {
        foreach ($validationParams as $key) {
            $this->errorHandler->set($key, $this->{$key . "Validation"}());
        }
        return $this->errorHandler->handleErrors();
    }

    private function set(string $data): bool
    {
        return ! empty($this->postData[$data]);
    }

    public function emailValidation(): string | bool
    {
        $sanitizedEmail = filter_var($this->postData['email'], FILTER_SANITIZE_EMAIL);

        if (! self::set('email')) {
            return 'Email is required';
        }

        if (! filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL)) {
            return 'Invalid email format';
        }
        return true;
    }

    public function passwordValidation(): string | bool
    {
        if (! self::set('password')) {
            return 'Password is required';
        }

        if (! self::set($this->postData['confirm'])) {
            if (! self::match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/', 'password')) {
                return 'Password must contain at least one letter, one number and one special character';
            }
            if ($this->postData['password'] != $this->postData['confirm']) {
                return 'Passwords do not match';
            }
        }
        return true;
    }

    public function usernameValidation(): string | bool
    {
        if (! self::set('username')) {
            return 'Username is required';
        }

        if (! self::match('/^[a-zA-Z0-9_]{5,20}$/', 'username')) {
            return 'Username must be between 5 and 20 characters';
        }
        return true;
    }

    public function phoneValidation(): bool | string
    {
        if (! self::set('phone')) {
            return 'Phone is required';
        }

        if (! self::match('/^(\+|\d)[0-9]{7,16}$/', 'phone')) {
            return 'Invalid phone number';
        }
        return true;
    }

    private function match(string $pattern, string $data): bool
    {
        if (! preg_match($pattern, $this->postData[$data])) {
            return false;
        }
        return true;
    }
}