<?php

namespace App\Application\Contracts\In\DomainManagers;

interface IDistanceManager
{
    /**
     * @param float $lat1
     * @param float $lon1
     * @param float $lat2
     * @param float $lon2
     * @return float
     */
    public function calculate(float $lat1, float $lon1, float $lat2, float $lon2): float;
}
