<?php

namespace App\Infrastructure\Database\Repositories\Route;

use App\Application\Contracts\Out\Repositories\Route\IRouteRepository;
use App\Application\DTO\In\Route\ChangeUserRouteDto;
use App\Application\DTO\In\Route\CompletedRoutePointDto;
use App\Application\DTO\In\Route\CreateRouteDto;
use App\Application\DTO\In\Route\GetRoutesDto;
use App\Application\DTO\In\Route\GetUserRoutesDto;
use App\Application\Exceptions\Route\FailedToCreateRoute;
use App\Application\Exceptions\Route\IncorrectOrderRoutePoints;
use App\Application\Exceptions\Route\RouteIsCompleted;
use App\Application\Exceptions\Route\RouteNotFound;
use App\Application\Exceptions\Route\UserHaveNotActiveRoute;
use App\Application\Exceptions\Route\UserRouteProgressNotFound;
use App\Infrastructure\Database\Models\Filters\Route\RouteFilterFactory;
use App\Infrastructure\Database\Models\Route;
use App\Infrastructure\Database\Models\RoutePoint;
use App\Infrastructure\Database\Models\UserActiveRoute;
use App\Infrastructure\Database\Models\UserFavoriteRoute;
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

    /**
     * @param GetUserRoutesDto $getUserRoutesDto
     * @return CursorPaginator
     */
    public function getUsersRoutes(GetUserRoutesDto $getUserRoutesDto): CursorPaginator
    {
        return Route::query()
            ->where('creator_id', $getUserRoutesDto->userId)
            ->cursorPaginate(perPage: $getUserRoutesDto->limit, cursor: $getUserRoutesDto->cursor);
    }

    /**
     * @param int $userId
     * @param int $routeId
     * @return void
     * @throws RouteNotFound
     */
    public function deleteUserRoute(int $userId, int $routeId): void
    {
        $route = Route::query()
            ->where('id', $routeId)
            ->where('creator_id', $userId);

        if($route->get()->isEmpty()){
            throw new RouteNotFound();
        }

        $route->delete();
    }

    /**
     * @param int $userId
     * @return UserActiveRoute
     * @throws UserHaveNotActiveRoute
     */
    public function getActiveUserRoute(int $userId): UserActiveRoute
    {
        /** @var UserActiveRoute $userActiveRoute */
        $userActiveRoute = UserActiveRoute::query()
            ->where('user_id', $userId)
            ->get()
            ->first();

        if(!$userActiveRoute){
            throw new UserHaveNotActiveRoute();
        }

        return $userActiveRoute;
    }

    /**
     * @param ChangeUserRouteDto $changeActiveUserRouteDto
     * @return UserActiveRoute
     * @throws RouteIsCompleted
     */
    public function changeActiveUserRoute(ChangeUserRouteDto $changeActiveUserRouteDto): UserActiveRoute
    {
        $route = Route::query()
            ->where('id', $changeActiveUserRouteDto->routeId)
            ->get()
            ->first();

        $userActiveRoute = UserRouteProgress::query()
            ->where('user_id', $changeActiveUserRouteDto->userId)
            ->whereIn('route_point_id', $route->routePoints->pluck('id'))
            ->get();

        if($userActiveRoute->where("is_completed", true)
                ->count() === $route->routePoints->count()){
            throw new RouteIsCompleted();
        }

        if(UserRouteProgress::query()
            ->where('user_id', $changeActiveUserRouteDto->userId)
            ->whereIn('route_point_id', $route->routePoints->pluck('id'))
            ->get()->isEmpty()) {
            $route->routePoints()->each(function ($routePoint) use ($changeActiveUserRouteDto) {
                UserRouteProgress::query()->create([
                    'user_id' => $changeActiveUserRouteDto->userId,
                    'route_point_id' => $routePoint->id,
                ]);
            });
        }

        return UserActiveRoute::query()
            ->updateOrCreate([
                'user_id' => $changeActiveUserRouteDto->userId,
            ], [
                'route_id' =>  $changeActiveUserRouteDto->routeId,
            ])->get()->first();
    }

    /**
     * @param GetUserRoutesDto $getUserRoutesDto
     * @return CursorPaginator
     */
    public function getFavoriteUserRoutes(GetUserRoutesDto $getUserRoutesDto): CursorPaginator
    {
        return Route::query()->whereIn('id', UserFavoriteRoute::query()
            ->where('user_id', $getUserRoutesDto->userId)->get()->pluck('route_id'))
            ->cursorPaginate(perPage: $getUserRoutesDto->limit, cursor: $getUserRoutesDto->cursor);
    }

    /**
     * @param ChangeUserRouteDto $changeUserRouteDto
     * @return Route
     */
    public function addRouteToUserFavorite(ChangeUserRouteDto $changeUserRouteDto): Route
    {
        /** @var UserFavoriteRoute $userFavoriteRoute */
        $userFavoriteRoute = UserFavoriteRoute::query()->create([
            'user_id' => $changeUserRouteDto->userId,
            'route_id' => $changeUserRouteDto->routeId,
        ]);

        return $userFavoriteRoute->route;
    }

    /**
     * @param int $userId
     * @param int $routeId
     * @return void
     * @throws RouteNotFound
     */
    public function deleteRouteFromUserFavorite(int $userId, int $routeId): void
    {
        $route = UserFavoriteRoute::query()
            ->where('route_id', $routeId)
            ->where('user_id', $userId);

        if($route->get()->isEmpty()){
            throw new RouteNotFound();
        }

        $route->delete();
    }
}
