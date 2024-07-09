<?php

declare(strict_types=1);

namespace Src\Interfaces;

use Src\Http\Session;

interface Middleware
{
//    public function __construct();
    public function handle();

}