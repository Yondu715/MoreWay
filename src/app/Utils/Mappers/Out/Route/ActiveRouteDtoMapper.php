<?php

namespace App\Utils\Mappers\Out\Route;

use App\Application\DTO\Out\Route\ActiveRouteDto;
use App\Infrastructure\Database\Models\UserActiveRoute;

class ActiveRouteDtoMapper
{
    /**
     * @param UserActiveRoute $userActiveRoute
     * @return ActiveRouteDto
     */
    public static function fromRouteModel(UserActiveRoute $userActiveRoute): ActiveRouteDto
    {
        return new ActiveRouteDto(
            isGroup: $userActiveRoute->is_group,
            route: RouteDtoMapper::fromRouteModel($userActiveRoute->route),
        );
    }
}
