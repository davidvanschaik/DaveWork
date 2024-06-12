<?php

declare(strict_types=1);

require '../vendor/autoload.php';

session_start();

$kernel = new Src\Foundation\Routing\Kernel();
$kernel->handle();
