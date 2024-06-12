<?php

declare(strict_types=1);

namespace App\Helpers;

use Jenssegers\Blade\Blade;

class ViewHelper
{
    public static function template($templateName, array $data): void
    {
        $blade = new Blade('views','cache')
    }
}