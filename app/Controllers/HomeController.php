<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\ViewHelper;
use Src\Http\Request;

class HomeController
{
    public function index(Request $request)
    {

      echo 'hallo!';
    }
}