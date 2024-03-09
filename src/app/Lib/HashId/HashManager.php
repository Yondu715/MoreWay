<?php

namespace App\Lib\HashId;

use Hashids\Hashids;

class HashManager
{

    private static Hashids $hashids = new Hashids('ggIKLdf', 8);

    /**
     * @param int $id
     * @return string
     */
    static public function encrypt(int $id): string
    {
        return self::$hashids->encode($id);
    }

    /**
     * @param string $hash
     * @return int
     */
    static public function decrypt(string $hash): int
    {
        return self::$hashids->decode($hash)[0];
    }
}
