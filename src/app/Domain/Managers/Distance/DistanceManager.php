<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Domain\Managers\Distance;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Domain\Contracts\In\DomainManagers\IDistanceManager;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Domain\Enams\Earth\EarthInformation;

class DistanceManager implements IDistanceManager
{
    /**
     * @param float $lat1
     * @param float $lon1
     * @param float $lat2
     * @param float $lon2
     * @return float
     */
    public function calculate(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round(EarthInformation::Radius->value * $c, 1);
    }
}
