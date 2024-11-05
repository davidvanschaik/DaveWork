<?php

namespace Src\Helpers;

class CLIHelper
{
    public const RESET = "\033[0m";
    public const BLACK = "\033[0;30m";
    public const RED = "\033[0;31m";
    public const GREEN = "\033[0;32m";
    public const YELLOW = "\033[0;33m";
    public const BLUE = "\033[0;34m";
    public const MAGENTA = "\033[0;35m";
    public const CYAN = "\033[0;36m";
    public const WHITE = "\033[0;37m";

    public static function echo(string $color, string $message): string
    {
        return self::{$color} . $message . self::RESET . PHP_EOL;
    }
}