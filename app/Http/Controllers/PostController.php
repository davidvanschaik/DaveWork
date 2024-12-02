<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Src\Http\Request;

class PostController
{
    public function index(): void
    {
        echo 'This is my PostController index method!';
    }

    public function show(Request $request): void
    {
        echo "This is my PostController show method! The post id is: {$request->parameters->id}";
    }
}