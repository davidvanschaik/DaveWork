<?php

declare(strict_types=1);

namespace App\Controllers;

use Src\Http\Request;

class HomeController
{
    public function index(): void
    {
        redirect('like.index');
    }

    public function show(Request $request): void
    {
        echo "This is my HomeController show method! ID = " . $request->parameters->id;
        redirect('home.index');
    }

    public function user(): void
    {
        echo 'This is my HomeController user method!';
    }
}