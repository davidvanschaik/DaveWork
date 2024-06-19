<?php

declare(strict_types=1);

namespace Src\Middleware;

use Src\Http\Session;
use Src\Interfaces\Middleware;

class VerificationMiddleware implements Middleware
{

    public function __construct(Session $session) {}

    public function handle()
    {
        // TODO: Implement handle() method.
    }
}