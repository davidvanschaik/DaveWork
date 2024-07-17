<?php

declare(strict_types=1);

namespace Src\View;

use Jenssegers\Blade\Blade;

class View
{
    protected Blade $blade;
    public function __construct()
    {
        $viewsPath = __DIR__ . '/../../resources/views';
        $cachePath = __DIR__ . '/../../storage/cache';
        $this->blade = new Blade($viewsPath, $cachePath);
    }

    public function render(string $templateName, array $data)
    {
       return $this->blade->render($templateName, $data);
    }
}