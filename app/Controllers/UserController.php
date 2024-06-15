<?php

declare(strict_types=1);

namespace App\Controllers;

use Src\Http\Request;

class UserController
{
    public function index(): void
    {
        echo 'This is my UserController index method!';
    }

    public function show(Request $request): void
    {
        echo "This is my UserController show method! The user id is: {$request->parameters->id}";
    }

}