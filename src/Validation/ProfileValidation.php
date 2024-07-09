<?php

declare(strict_types=1);

namespace Src\Validation;

class ProfileValidation
{
    private static array $data;

    public function __construct(array $data)
    {
        self::$data = $data;
    }

    public static function set($data): bool
    {
        if (isset(self::$data[$data])) {
            return true;
        }
        return false;
    }

    public static function emailValidation(): ?string
    {
        if (! self::set('email')) {
            return 'Email is required';
        }

        $sanitizedEmail = filter_var(self::$data['email'], FILTER_SANITIZE_EMAIL);

        if (! filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL)) {
            return 'Invalid email format';
        }
        return null;
    }

    public static function passwordValidation(): ?string
    {
        if (! self::set('password')) {
            return 'Password is required';
        }

        if (isset(self::$data['conf-password'])) {
            if (self::$data['password'] !== self::$data['conf-password']) {
                return 'Passwords do not match';
            }
        }

        $pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/';
        if (! preg_match($pattern, self::$data['password'])) {
            return 'Password must contain at least one letter, one number and one special character';
        }
        return null;
    }

    public static function phoneValidation(): ?string
    {
        if (! self::set('phone')) {
            return 'Phone is required';
        }

        $pattern = '/^(\+|\d)[0-9]{7,16}$/;';
        if (! preg_match($pattern, self::$data['phone'])) {
            return 'Invalid phone number';
        }
        return null;
    }

    public static function usernameValidation(): ?string
    {
        if (! self::set('username')) {
            return 'Username is required';
        }

        $pattern = '/^[a-zA-Z0-9_]{5,20}$/';
        if (! preg_match($pattern, self::$data['username'])) {
            return 'Username must be between 5 and 20 characters';
        }
        return null;
    }
}