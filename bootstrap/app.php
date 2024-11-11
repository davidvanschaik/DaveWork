<?php

declare(strict_types=1);

use Src\Core\App;

require __DIR__ . '/../src/Helpers/helpers.php';
require __DIR__ . '/../routes/web.php';
require '../src/Console/Commands/Server/router.php';

App::getInstance()->run();