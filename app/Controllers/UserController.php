<?php

declare(strict_types=1);

namespace App\Controllers;

use Src\Http\Request;
class UserController
{
    public function index()
    {
        echo $_SERVER['REQUEST_URI'];
        echo 'Hoi Ali!';
    }

}