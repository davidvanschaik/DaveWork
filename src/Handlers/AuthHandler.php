<?php

declare(strict_types=1);

namespace Src\Handlers;

class AuthHandler
{
    public static function check(): void
    {
        if (! isset($_SESSION['user_id'])) {
            $_SESSION['user_id'] = 0;
            header('Location: /login');
        }
    }

}
