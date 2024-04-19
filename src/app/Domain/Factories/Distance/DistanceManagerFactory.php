<?php

namespace App\Domain\Factories\Distance;

use App\Domain\Contracts\In\DomainManagers\IDistanceManager;
use App\Domain\Managers\Distance\DistanceManager;

class DistanceManagerFactory
{
    public static function createInstance(): IDistanceManager
    {
        return new DistanceManager();
    }
}
