<?php

declare(strict_types=1);

namespace Src\Validation;

class SignupValidation
{
    private static array $postData;

    public function __construct(array $data)
    {
        self::$postData = $data;
    }

    private static function set(string $data): bool
    {
        return ! empty(self::$postData[$data]);
    }

    public static function emailValidation(): string | bool
    {
        $sanitizedEmail = filter_var(self::$postData['email'], FILTER_SANITIZE_EMAIL);

        if (! self::set('email')) {
            return 'Email is required';
        }

        if (! filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL)) {
            return 'Invalid email format';
        }
        return true;
    }

    public static function passwordValidation(): string | bool
    {
        if (! self::set('password')) {
            return 'Password is required';
        }

        if (! self::set(self::$postData['confirm'])) {
            if (! self::match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/', 'password')) {
                return 'Password must contain at least one letter, one number and one special character';
            }
            if (self::$postData['password'] != self::$postData['confirm']) {
                return 'Passwords do not match';
            }
        }
        return true;
    }

    public static function usernameValidation(): string | bool
    {
        if (! self::set('username')) {
            return 'Username is required';
        }

        if (! self::match('/^[a-zA-Z0-9_]{5,20}$/', 'username')) {
            return 'Username must be between 5 and 20 characters';
        }
        return true;
    }

    public static function phoneValidation(): bool | string
    {
        if (! self::set('phone')) {
            return 'Phone is required';
        }

        if (! self::match('/^(\+|\d)[0-9]{7,16}$/', 'phone')) {
            return 'Invalid phone number';
        }
        return true;
    }

    private static function match(string $pattern, string $data): bool
    {
        if (! preg_match($pattern, self::$postData[$data])) {
            return false;
        }
        return true;
    }
}