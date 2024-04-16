<?php

namespace App\Application\Contracts\Out\Managers\Hash;

interface IHashManager
{
    /**
     * @param string $value
     * @param string $hashedValue
     * @return bool
     */
    public function check(string $value, string $hashedValue): bool;

    /**
     * @param string $value
     * @return string
     */
    public function make(string $value): string;
}
