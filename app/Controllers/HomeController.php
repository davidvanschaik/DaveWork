<?php

declare(strict_types=1);

namespace App\Controllers;

use Src\Http\Request;

class HomeController
{
    public function index(): void
    {
        dd($_SESSION);
    }

    public function show(Request $request): void
    {
        echo "This is my HomeController show method! ID = " . $request->parameters->id;
    }

    public function user(): void
    {
        echo 'This is my HomeController user method!';
    }
}