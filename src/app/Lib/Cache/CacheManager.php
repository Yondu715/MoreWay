<?php

namespace App\Lib\Cache;

use Illuminate\Support\Facades\Cache;

class CacheManager implements ICacheManager
{
    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public function put(string $key, string $value): void
    {
        Cache::put($key, $value, now()->addMinutes(5));
    }

    /**
     * @param string $key
     * @return ?string
     */
    public function get(string $key): ?string
    {
        return Cache::get($key);
    }
}
