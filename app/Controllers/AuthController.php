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
//        $errors = [
//            'test' => 'dit is een test bericht',
//            'test2' => 'dit is ook een test bericht'
//        ];
//        echo view('login', ['errors' => $errors]);
        echo base64_encode('e86bb2e7d8d517adacbd9da423ae4fd5001db888');
    }

    public function login(Request $request): void
    {
        $errors = errors();
        var_dump($errors);
    }
}