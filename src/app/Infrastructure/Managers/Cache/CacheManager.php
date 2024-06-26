<?php

namespace App\Infrastructure\Managers\Cache;

use App\Application\Contracts\Out\Managers\Cache\ICacheManager;
use Illuminate\Support\Facades\Cache;

class CacheManager implements ICacheManager
{
    /**
     * @param string $key
     * @param string $value
     * @param int $seconds
     * @return void
     */
    public function put(string $key, string $value, int $seconds): void
    {
        Cache::put($key, $value, $seconds);
    }

    /**
     * @param string $key
     * @return ?string
     */
    public function get(string $key): ?string
    {
        return Cache::get($key);
    }

    /**
     * @param string $key
     * @return void
     */
    public function delete(string $key): void
    {
        Cache::forget($key);
    }
}
