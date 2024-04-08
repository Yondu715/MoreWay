<?php

namespace App\Application\Contracts\Out\Repositories;

use App\Application\DTO\In\Route\CreateRouteDto;
use App\Application\Exceptions\Route\FailedToCreateRoute;
use App\Infrastructure\Database\Models\Route;

interface IRouteRepository
{
    /**
     * @param CreateRouteDto $createRouteDto
     * @return Route
     * @throws FailedToCreateRoute
     */
    public function create(CreateRouteDto $createRouteDto):Route;
}
