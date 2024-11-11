<?php

namespace Src\Console;

class Response
{
//    font colors for CLI;
    public const RESET = "\033[0m";
    public const RED = "\033[0;31m";
    public const GREEN = "\033[0;32m";
    public const YELLOW = "\033[0;33m";
    public const GRAY = "\033[90m";

//    background colors for command line interface
    public const BLUE_BG = "\033[104m";

    public static function error(): false
    {
        echo self::block() . self::echo("RED", " Invalid command given. \n \n");
        echo '    More info: ' . self::echo('GREEN', "'php commander help' \n \n");
        return false;
    }

    public static function echo(string $color, string $message): string
    {
        return self::{$color} . $message . self::RESET;
    }

    public static function block(): string
    {
        return "\n    " . self::BLUE_BG . ' INFO ' . self::RESET;
    }
}