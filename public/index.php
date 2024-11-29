<?php

declare(strict_types=1);

use Src\Core\App;
use Src\Routing\Kernel;
use Src\Routing\RouteRegistration;

require '../vendor/autoload.php';
require_once '../bootstrap/app.php';
require '../src/Console/router.php';

$kernel = new Kernel(new RouteRegistration(), App::getInstance());
$kernel->handle();
