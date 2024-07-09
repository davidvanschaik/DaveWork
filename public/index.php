<?php

declare(strict_types=1);

use Src\Http\Session;
use Src\Routing\Kernel;
use Src\Routing\RouteRegistration;

require '../vendor/autoload.php';
require __DIR__ . '/../routes/Routes.php';
require __DIR__ . '/../bootstrap/app.php';

$kernel = new Kernel(new RouteRegistration());
$kernel->handle();
