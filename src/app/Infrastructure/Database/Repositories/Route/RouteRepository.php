<?php

namespace App\Infrastructure\Database\Repositories\Route;

use App\Application\Contracts\Out\Repositories\Route\IRouteRepository;
use App\Application\DTO\In\Route\CreateRouteDto;
use App\Application\DTO\In\Route\GetRoutesDto;
use App\Application\Exceptions\Route\FailedToCreateRoute;
use App\Application\Exceptions\Route\RouteNotFound;
use App\Infrastructure\Database\Models\Filters\Route\RouteFilterFactory;
use App\Infrastructure\Database\Models\Route;
use App\Infrastructure\Database\Models\RoutePoint;
use App\Infrastructure\Database\Transaction\Interface\ITransactionManager;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Throwable;

class RouteRepository implements IRouteRepository
{
    public function __construct(
      private readonly ITransactionManager $transactionManager,
      private readonly RouteFilterFactory $routeFilterFactory
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

    /**
     * @param int $routeId
     * @return Route
     * @throws RouteNotFound
     */
    public function getRouteById(int $routeId): Route
    {
        try {
            /** @var Route $route */
            $route = Route::query()->findOrFail($routeId);
            return $route;
        } catch (Throwable) {
            throw new RouteNotFound();
        }
    }

    /**
     * @param GetRoutesDto $getRoutesDto
     * @return CursorPaginator
     * @throws RouteNotFound
     */
    public function getRoutes(GetRoutesDto $getRoutesDto): CursorPaginator
    {
        try {
            return Route::query()
            ->filter($this->routeFilterFactory->create($getRoutesDto->filter))
            ->cursorPaginate(perPage: $getRoutesDto->limit ?? 2, cursor: $getRoutesDto->cursor);
        } catch (Throwable $throwable) {
            dd($throwable->getMessage(), $throwable->getCode(), $throwable);
        }
    }
}
