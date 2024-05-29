<?php

namespace App\Application\Contracts\Out\Managers\Cache;

interface ICacheManager
{
    /**
     * @param string $key
     * @param string $value
     * @param int $seconds
     * @return void
     */
    public function put(string $key, string $value, int $seconds): void;

    /**
     * @param string $key
     * @return string|null
     */
    public function get(string $key): ?string;
}
