<?php

declare(strict_types=1);

namespace App\Controllers;

use Src\Core\App;
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
//        $errors = errors();
//        echo view('login', ['errors' => $errors]);
        echo base64_encode('3a56c8518a6eea8b8c2adf48896f013f80921ca2');
    }

    public function login(Request $request): void
    {
        $errors = errors();
        var_dump($errors);
    }
}