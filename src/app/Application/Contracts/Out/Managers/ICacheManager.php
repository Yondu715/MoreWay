<?php

namespace App\Application\Contracts\Out\Managers;

interface ICacheManager
{
    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public function put(string $key, string $value): void;

    /**
     * @param string $key
     * @return string|null
     */
    public function get(string $key): ?string;
}
