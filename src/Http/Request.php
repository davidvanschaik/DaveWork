<?php

declare(strict_types=1);

namespace Src\Http;

class Request
{
    public readonly object $parameters;
    public function __construct($params)
    {
        $this->parameters = (object) $params;
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function uri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public static function QueryParams()
    {
        return $_GET;
    }

    public static function BodyParams()
    {
        return $_POST;
    }
}