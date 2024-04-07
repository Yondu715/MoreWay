<?php

namespace App\Infrastructure\Managers\Hash;

use App\Application\Contracts\Out\Managers\IHashManager;
use Illuminate\Support\Facades\Hash;

class HashManager implements IHashManager
{
    public function make(string $value): string
    {
        return Hash::make($value);
    }

    public function check(string $value, string $hashedValue): bool
    {
        return Hash::check($value, $hashedValue);
    }
}