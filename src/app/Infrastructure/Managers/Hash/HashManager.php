<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Managers\Hash;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Managers\Hash\IHashManager;
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
