<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\ViewHelper;
use Src\Http\Request;
use Jenssegers\Blade\Blade;

class AuthController
{
    public ViewHelper $view;
    public function __construct()
    {
        $this->view = new ViewHelper();
    }
    public function make(Request $request): void
    {
        $this->view->render('login', ['username' => '']);
    }

    public function login()
    {
        
    }
}