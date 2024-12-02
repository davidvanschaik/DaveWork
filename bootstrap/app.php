<?php

declare(strict_types=1);

use Src\Core\App;
use Src\Helpers\EnvHelper;

require __DIR__ . '/../src/Helpers/helpers.php';
require __DIR__ . '/../routes/web.php';

EnvHelper::load();
App::getInstance()->run();