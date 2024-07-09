<?php

declare(strict_types=1);

namespace Src\Handlers;

use Jenssegers\Blade\Blade;

class ViewHandler
{
    protected Blade $blade;
    public function __construct()
    {
        $viewsPath = __DIR__ . '/../../resources/views';
        $cachePath = __DIR__ . '/../../resources/cache';
        $this->blade = new Blade($viewsPath, $cachePath);
    }

}