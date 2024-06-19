<?php

declare(strict_types=1);

namespace Src\Middleware;

use Src\Http\Request;
use Src\Http\Session;
use Src\Interfaces\Middleware;

class ValidationMiddleware implements Middleware
{

    public function __construct(
        private readonly Session $session
    ) {}

    public function handle(): void
    {
        var_dump(Request::method(), Request::uri());
    }

    private function validate(array $parameters): void
    {
//        if (Request::uri() ==  '')
    }
}