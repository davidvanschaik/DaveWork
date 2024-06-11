<?php

declare(strict_types=1);

namespace App\Helpers;

use Twig\loader\filesystemloader;
use Twig\environment;

class ViewHelper
{
    public static function template($templateName, array $data): void
    {
        $twig = new Environment(new FilesystemLoader('../resources/views'));
        $twig->display($templateName, $data);
    }
}