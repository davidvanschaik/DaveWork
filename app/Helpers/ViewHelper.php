<?php

declare(strict_types=1);

namespace app\Helpers;

use Jenssegers\Blade\Blade;

class ViewHelper
{
    public static function template($templateName, array $data): void
    {
        $blade = new Blade('views','cache');
    }
}