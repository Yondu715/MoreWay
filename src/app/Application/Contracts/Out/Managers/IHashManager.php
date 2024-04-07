<?php

namespace App\Application\Contracts\Out\Managers;

interface IHashManager
{
    public function check(string $value, string $hashedValue): bool;

    public function make(string $value): string;
}