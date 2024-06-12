<?php

require_once __DIR__ . '/vendor/autoload.php';

use Src\cmd\MigrateCommand;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new MigrateCommand());
echo 'starting';
$application->run();