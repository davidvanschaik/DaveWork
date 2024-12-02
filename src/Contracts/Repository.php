<?php

declare(strict_types=1);

namespace Src\Contracts;

interface Repository
{
    public function insert(mixed $info): void;

    public function delete(): void;

    public function getAll(): array;
}