<?php

namespace Src\Contracts;

Interface Command
{
    public function __invoke(): void;
}