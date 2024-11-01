<?php

declare(strict_types=1);

namespace Src\Http;

use DateTime;

class Session
{
    protected string $flashKey;

    public function __construct()
    {
        $this->flashKey = 'flash';
        session_start();
    }

    public function setActive(): void
    {
        $_SESSION['LAST_ACTIVE'] = (new DateTime())->format('Y-m-d H:i:s');
    }

    public function set(string $key, string | array | int $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key): mixed
    {
        if ($key == 'errors') {
           return $this->getErrors($key);
        }
        return $_SESSION[$key] ?? [];
    }

    public function getErrors(string $key): array
    {
        if ($this->has($key)) {
            $errors = $_SESSION[$key];
            $this->unset($key);
        }
        return $errors ?? [];
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function destroy(): void
    {
        session_destroy();
        session_start();
    }

    public function unset(string $key, string $flashKey = ''): void
    {
        if ($flashKey !== '') {
            unset($_SESSION[$this->flashKey][$key]);
        }
        unset($_SESSION[$key]);
    }

    public function generate(): void
    {
        session_regenerate_id(true);
    }

    public function setFlash(string $key, string $value): void
    {
        $_SESSION[$this->flashKey][$key] = $value;
    }

    public function getFlash(string $key): string
    {
        $flash = $_SESSION[$this->flashKey][$key];
        $this->unset($key);
        return $flash;
    }

    public function generateCSRF(): string
    {
        $token = bin2hex(random_bytes(32));
        $this->set('csrf_token', $token);
        return $token;
    }

    public function verifyCSRF(string $token): bool
    {
        return $this->get('csrf_token') === $token;
    }
}