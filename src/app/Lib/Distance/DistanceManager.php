<?php

namespace App\Lib\Distance;

class DistanceManager
{
    /**
     * @param float $lat1
     * @param float $lon1
     * @param float $lat2
     * @param float $lon2
     * @return float
     */
    public static function calc(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $dLat = $lat2 - $lat1;
        $dLon = $lon2 - $lon1;

        $a = sin($dLat/2) * sin($dLat/2)
            + cos($lat1) * cos($lat2) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));

        $earthRadius = 6371;

        return round($earthRadius * $c, 1);
    }
}
