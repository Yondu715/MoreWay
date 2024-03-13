<?php

namespace App\Lib\HashId;

use Hashids\Hashids;

class HashManager
{    
    /**
     * @param int $id
     * @return string
     */
    static public function encrypt(int $id): string
    {
        $hashids = new Hashids(
            config('hashids.connections.main.salt'),
            config('hashids.connections.main.length')
        );
        return $hashids->encode($id);
    }

    /**
     * @param string $hash
     * @return int
     */
    static public function decrypt(string $hash): int
    {
        $hashids = new Hashids(
            config('hashids.connections.main.salt'),
            config('hashids.connections.main.length')
        );
        return $hashids->decode($hash)[0];
    }
}
