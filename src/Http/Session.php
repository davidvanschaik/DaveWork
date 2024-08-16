<?php

declare(strict_types=1);

namespace Src\Http;

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
        $_SESSION['LAST_ACTIVE'] = date("H:i:s");
    }

    public function set(string $key, string | array $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key): string | array
    {
        if ($key == 'errors') {
            $this->getErrors($key);
        }
        return $_SESSION[$key] ?? [];
    }

    public function getErrors($key): array
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
        session_unset();
        session_destroy();
    }

    public function unset(string $key, string $flashKey = ''): void
    {
        if ($flashKey == '') {
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

    private function setTimeOutTime(): string
    {
        $lastActive = explode(':', $_SESSION['LAST_ACTIVE']);
        (int)$lastActive[0] += 1;
        return implode(':', $lastActive);
    }

    public function timeOut(): void
    {
        if ($_SESSION['LAST_ACTIVE'] == $this->setTimeOutTime()) {
            session_unset();
            session_destroy();
        }
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