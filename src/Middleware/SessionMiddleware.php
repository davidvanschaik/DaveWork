<?php

declare(strict_types=1);

namespace Src\Middleware;

use Src\Interfaces\Middleware;

class SessionMiddleware implements Middleware
{
        public function handle(): bool
        {
            $session = '';
        }
}