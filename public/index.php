<?php

declare(strict_types=1);

use Src\Routing\Kernel;
use Src\Routing\RouteRegistration;

require '../vendor/autoload.php';
require __DIR__ . '/../routes/Routes.php';

session_start();

$kernel = new Kernel(new RouteRegistration());
$kernel->handle();
