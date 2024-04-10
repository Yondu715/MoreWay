<?php

namespace App\Application\Contracts\Out\InfrastructureManagers;

interface IHashManager
{
    public function check(string $value, string $hashedValue): bool;

    public function make(string $value): string;
}
