<?php

declare(strict_types=1);

namespace App\Controllers;

require 'function.php';

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
        $errors = $request->getErrors();
        $this->view->render('login', [
            'errors' => $errors
        ]);
    }

    public function login(): void
    {
        var_dump($_REQUEST);
    }
}