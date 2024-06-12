<?php

declare(strict_types=1);

namespace App\Controllers;

use Src\Http\Request;

class HomeController
{
    public function index(): void
    {
        echo 'This is my HomeController index method!';
    }

    public function show(): void
    {
        echo 'This is my HomeController show method!';
    }
}