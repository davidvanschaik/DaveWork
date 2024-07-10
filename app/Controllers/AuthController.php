<?php

declare(strict_types=1);

namespace App\Controllers;

use Src\Http\Request;
use Src\View\View;

class AuthController
{
    public View $view;
    public function __construct()
    {
        $this->view = new View();
    }
    public function make(Request $request): void
    {
        view('login', []);
    }

    public function login(Request $request): void
    {
        dd($request->BodyParams());
    }
}