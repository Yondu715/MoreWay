<?php

namespace App\Infrastructure\Database\Repositories\Route;

use App\Application\Contracts\Out\Repositories\Route\IRouteRepository;
use App\Application\DTO\In\Route\CompletedRoutePointDto;
use App\Application\DTO\In\Route\CreateRouteDto;
use App\Application\DTO\In\Route\GetRoutesDto;
use App\Application\Exceptions\Route\FailedToCreateRoute;
use App\Application\Exceptions\Route\IncorrectOrderRoutePoints;
use App\Application\Exceptions\Route\RouteNotFound;
use App\Application\Exceptions\Route\UserRouteProgressNotFound;
use App\Infrastructure\Database\Models\Filters\Route\RouteFilterFactory;
use App\Infrastructure\Database\Models\Route;
use App\Infrastructure\Database\Models\RoutePoint;
use App\Infrastructure\Database\Models\UserActiveRoute;
use App\Infrastructure\Database\Models\UserRouteProgress;
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
     */
    public function getRoutes(GetRoutesDto $getRoutesDto): CursorPaginator
    {
        return Route::query()
        ->filter($this->routeFilterFactory->create($getRoutesDto->filter))
        ->cursorPaginate(perPage: $getRoutesDto->limit, cursor: $getRoutesDto->cursor);
    }

    /**
     * @param CompletedRoutePointDto $completedRoutePointDto
     * @return void
     * @throws UserRouteProgressNotFound
     * @throws IncorrectOrderRoutePoints
     * @throws RouteNotFound
     */
    public function changeUserRouteProgress(CompletedRoutePointDto $completedRoutePointDto): void
    {
        /** @var UserActiveRoute $activeRoute */
        $activeRoute = UserActiveRoute::query()
            ->where('user_id', $completedRoutePointDto->userId)
            ->first();

        if (!$activeRoute) {
            throw new UserRouteProgressNotFound();
        }

        /** @var RoutePoint $routePoint */
        $routePoint = RoutePoint::query()
            ->where('id', $completedRoutePointDto->routePointId)
            ->where('route_id', $activeRoute->route_id)
            ->first();

        if (!$routePoint) {
            throw new RouteNotFound();
        }

        $route = $routePoint->route;

        if ($route->routePoints->pluck('id')->min() !== $completedRoutePointDto->routePointId) {
            /** @var UserRouteProgress $prevRoutePoint */
            $prevRoutePoint = UserRouteProgress::query()
                ->where('user_id', $completedRoutePointDto->userId)
                ->where('route_point_id', $completedRoutePointDto->routePointId - 1)
                ->where('is_completed', true)
                ->first();

            if (!$prevRoutePoint) {
                throw new IncorrectOrderRoutePoints();
            }
        }

        /** @var UserRouteProgress $routePointProgress */
        $routePointProgress = UserRouteProgress::query()
            ->where('user_id', $completedRoutePointDto->userId)
            ->where('route_point_id', $completedRoutePointDto->routePointId)
            ->first();

        if (!$routePointProgress) {
            throw new UserRouteProgressNotFound();
        }

        $routePointProgress->update(['is_completed' => true]);

        $userProgresses = UserRouteProgress::query()
            ->where('user_id', $completedRoutePointDto->userId)
            ->whereIn('route_point_id', $route->routePoints->pluck('id'))
            ->where('is_completed', true)
            ->count();

        if ($userProgresses === $route->routePoints->count()) {
            $activeRoute->forceDelete();
        }
    }
}
