<?php

declare(strict_types=1);

namespace App\Helpers;

use Jenssegers\Blade\Blade;

class ViewHelper
{
    protected Blade $blade;
    public function __construct()
    {
        $viewsPath = __DIR__ . '/../../resources/views';
        $cachePath = __DIR__ . '/../../resources/cache';
        $this->blade = new Blade($viewsPath, $cachePath);
    }
    public function make($templateName, array $data)
    {
        $this->blade->make($templateName, $data)->render();
    }

    public function render($templateName, array $data): void
    {
        echo $this->blade->render($templateName, $data);
    }
}