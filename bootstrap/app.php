<?php

declare(strict_types=1);

use Src\Core\App;
use Src\Routing\Kernel;

require __DIR__ . '/../src/Helpers/helpers.php';
require __DIR__ . '/../routes/web.php';

App::getInstance()->run();