<?php

namespace App\Infrastructure\Database\Repositories\Route;

use App\Application\Contracts\Out\Managers\ITransactionManager;
use App\Application\Contracts\Out\Repositories\IRouteRepository;
use App\Application\DTO\In\Route\CreateRouteDto;
use App\Application\Exceptions\Route\FailedToCreateRoute;
use App\Infrastructure\Database\Models\Route;
use App\Infrastructure\Database\Models\RoutePoint;
use Throwable;

class RouteRepository implements IRouteRepository
{
    public function __construct(
      private readonly ITransactionManager $transactionManager
    ) {}

    /**
     * @param CreateRouteDto $createRouteDto
     * @return Route
     * @throws FailedToCreateRoute
     */
    public function create(CreateRouteDto $createRouteDto):Route
    {
        try {
            $this->transactionManager->beginTransaction();

            /** @var Route $route */
            $route = Route::query()->create([
                'name' => $createRouteDto->name,
                'creator_id' => $createRouteDto->userId
            ]);

            foreach ($createRouteDto->routePoints as $routePoint){
                RoutePoint::query()->create([
                    'index' => $routePoint->index,
                    'place_id' => $routePoint->placeId,
                    'route_id' => $route->id,
                ]);
            }

            $this->transactionManager->commit();

            return $route;
        } catch (Throwable) {
            $this->transactionManager->rollback();
            throw new FailedToCreateRoute();
        }
    }
}
