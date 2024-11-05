<?php

namespace Src\Console\Commands;

interface Command
{
    public function __construct(array $arg);
    public function setCommand();

}