<?php

namespace App\Infrastructure\Database\Repositories\Route;

use App\Application\Exceptions\Route\RouteNotFound;
use Exception;
use Throwable;
use Illuminate\Database\Eloquent\Model;
use App\Application\DTO\Out\Route\RouteDto;
use App\Application\DTO\Collection\CursorDto;
use App\Infrastructure\Database\Models\Route;
use App\Application\DTO\In\Route\GetRoutesDto;
use App\Utils\Mappers\Out\Route\RouteDtoMapper;
use App\Application\DTO\In\Route\CreateRouteDto;
use App\Application\DTO\Out\Route\ActiveRouteDto;
use App\Application\DTO\In\Route\GetUserRoutesDto;
use App\Infrastructure\Database\Models\RoutePoint;
use App\Application\Exceptions\Route\RouteNameIsTaken;
use App\Application\DTO\In\Route\ChangeUserRouteDto;
use App\Application\Exceptions\Route\RouteIsCompleted;
use App\Infrastructure\Database\Models\UserActiveRoute;
use App\Application\DTO\In\Route\CompletedRoutePointDto;
use App\Application\Exceptions\Route\FailedToCreateRoute;
use App\Infrastructure\Database\Models\UserFavoriteRoute;
use App\Infrastructure\Database\Models\UserRouteProgress;
use App\Application\Exceptions\Route\UserHaveNotActiveRoute;
use App\Infrastructure\Database\Models\RouteConstructorPoint;
use App\Application\Exceptions\Route\IncorrectOrderRoutePoints;
use App\Application\Exceptions\Route\UserRouteProgressNotFound;
use App\Application\Contracts\Out\Repositories\Route\IRouteRepository;
use App\Infrastructure\Database\Models\Filters\Route\RouteFilterFactory;
use App\Infrastructure\Database\Transaction\Interface\ITransactionManager;

class RouteRepository implements IRouteRepository
{
    private readonly Model $model;
    public function __construct(
        private readonly ITransactionManager $transactionManager,
        private readonly RouteFilterFactory $routeFilterFactory,
        Route $route
    ) {
        $this->model = $route;
    }

    /**
     * @param CreateRouteDto $createRouteDto
     * @return RouteDto
     * @throws FailedToCreateRoute
     * @throws RouteNameIsTaken
     */
    public function create(CreateRouteDto $createRouteDto): RouteDto
    {
        try {
            $this->transactionManager->beginTransaction();

            /** @var Route $route */
            $route = $this->model->query()->create([
                'name' => $createRouteDto->name,
                'creator_id' => $createRouteDto->userId
            ]);

            $routePoints = RouteConstructorPoint::with('constructor')
                ->whereHas('constructor', function ($query) use ($createRouteDto) {
                    $query->where('creator_id', $createRouteDto->userId);
                })->get();

            if ($routePoints->count() < 2 || $routePoints->count() > 15) {
                throw new FailedToCreateRoute();
            }

            $routePoints->each(function ($routePoint) use ($route) {
                RoutePoint::query()->create([
                    'index' => $routePoint->index,
                    'place_id' => $routePoint->place_id,
                    'route_id' => $route->id,
                ]);

                $routePoint->delete();
            });

            $this->transactionManager->commit();

            return RouteDtoMapper::fromRouteModel($route);
        } catch (Exception $exception) {
            $this->transactionManager->rollback();
            throw $exception;
        }
    }

    /**
     * @param int $routeId
     * @param int $userId
     * @return RouteDto
     * @throws RouteNotFound
     */
    public function getRouteById(int $routeId, int $userId): RouteDto
    {
        try {
            /** @var Route $route */
            $route = $this->model->query()->findOrFail($routeId);
            return RouteDtoMapper::fromRouteModelAndActiveFavorite($route, (boolean) UserActiveRoute::query()->where([
                'route_id' => $route->id,
                'user_id' => $userId
                ])->first(), (boolean) UserFavoriteRoute::query()->where([
                'route_id' => $route->id,
                'user_id' => $userId
            ])->first());
        } catch (Throwable) {
            throw new RouteNotFound();
        }
    }

    /**
     * @param GetRoutesDto $getRoutesDto
     * @return CursorDto
     */
    public function getRoutes(GetRoutesDto $getRoutesDto): CursorDto
    {
        $routes = $this->model
            ->filter($this->routeFilterFactory->create($getRoutesDto->filter))
            ->cursorPaginate(perPage: $getRoutesDto->limit, cursor: $getRoutesDto->cursor);
        return RouteDtoMapper::fromPaginator($routes);
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
                ->where([
                    'user_id' => $completedRoutePointDto->userId,
                    'route_point_id' => $completedRoutePointDto->routePointId - 1,
                    'is_completed' => true
                ])
                ->first();

            if (!$prevRoutePoint) {
                throw new IncorrectOrderRoutePoints();
            }
        }

        /** @var UserRouteProgress $routePointProgress */
        $routePointProgress = UserRouteProgress::query()
            ->where([
                'user_id' => $completedRoutePointDto->userId,
                'route_point_id' => $completedRoutePointDto->routePointId
            ])
            ->first();

        if (!$routePointProgress) {
            throw new UserRouteProgressNotFound();
        }

        $routePointProgress->update(['is_completed' => true]);

        $userProgresses = UserRouteProgress::query()
            ->where([
                'user_id' => $completedRoutePointDto->userId,
                'route_point_id' => $route->routePoints->pluck('id')
            ])
            ->whereIn('route_point_id', $route->routePoints->pluck('id'))
            ->count();

        if ($userProgresses === $route->routePoints->count()) {
            $activeRoute->forceDelete();
        }
    }

    /**
     * @param GetUserRoutesDto $getUserRoutesDto
     * @return CursorDto
     */
    public function getUsersRoutes(GetUserRoutesDto $getUserRoutesDto): CursorDto
    {
        $routes = $this->model->query()
            ->where('creator_id', $getUserRoutesDto->userId)
            ->cursorPaginate(perPage: $getUserRoutesDto->limit, cursor: $getUserRoutesDto->cursor);
        return RouteDtoMapper::fromPaginator($routes);
    }

    /**
     * @param int $userId
     * @param int $routeId
     * @return void
     * @throws RouteNotFound
     */
    public function deleteUserRoute(int $userId, int $routeId): void
    {
        $route = $this->model->query()
            ->where([
                'id' => $routeId,
                'creator_id' => $userId
            ]);

        if ($route->get()->isEmpty()) {
            throw new RouteNotFound();
        }

        $route->delete();
    }

    /**
     * @param int $userId
     * @return ActiveRouteDto
     * @throws UserHaveNotActiveRoute
     */
    public function getActiveUserRoute(int $userId): ActiveRouteDto
    {
        /** @var UserActiveRoute $userActiveRoute */
        $userActiveRoute = UserActiveRoute::query()
            ->where('user_id', $userId)
            ->first();

        if (!$userActiveRoute) {
            throw new UserHaveNotActiveRoute();
        }

        return RouteDtoMapper::fromActiveRouteModel($userActiveRoute);
    }

    /**
     * @param ChangeUserRouteDto $changeActiveUserRouteDto
     * @return ActiveRouteDto
     * @throws RouteIsCompleted
     */
    public function changeActiveUserRoute(ChangeUserRouteDto $changeActiveUserRouteDto): ActiveRouteDto
    {
        /** @var Route $route */
        $route = $this->model->query()
            ->where('id', $changeActiveUserRouteDto->routeId)
            ->first();

        $userActiveRoute = UserRouteProgress::query()
            ->where('user_id', $changeActiveUserRouteDto->userId)
            ->whereIn('route_point_id', $route->routePoints->pluck('id'))
            ->get();

        if (
            $userActiveRoute
            ->where("is_completed", true)
            ->count() === $route->routePoints->count()
        ) {
            throw new RouteIsCompleted();
        }

        if (UserRouteProgress::query()
            ->where('user_id', $changeActiveUserRouteDto->userId)
            ->whereIn('route_point_id', $route->routePoints->pluck('id'))
            ->get()->isEmpty()
        ) {
            $route->routePoints()->each(function ($routePoint) use ($changeActiveUserRouteDto) {
                UserRouteProgress::query()->create([
                    'user_id' => $changeActiveUserRouteDto->userId,
                    'route_point_id' => $routePoint->id,
                ]);
            });
        }

        /** @var UserActiveRoute $route */
        $route = UserActiveRoute::query()
            ->updateOrCreate([
                'user_id' => $changeActiveUserRouteDto->userId,
            ], [
                'route_id' =>  $changeActiveUserRouteDto->routeId,
            ])->first();
        return RouteDtoMapper::fromActiveRouteModel($route);
    }

    /**
     * @param GetUserRoutesDto $getUserRoutesDto
     * @return CursorDto
     */
    public function getFavoriteUserRoutes(GetUserRoutesDto $getUserRoutesDto): CursorDto
    {
        $routes = $this->model->query()->whereIn('id', UserFavoriteRoute::query()
            ->where('user_id', $getUserRoutesDto->userId)->get()->pluck('route_id'))
            ->cursorPaginate(perPage: $getUserRoutesDto->limit, cursor: $getUserRoutesDto->cursor);
        return RouteDtoMapper::fromPaginator($routes);
    }

    /**
     * @param ChangeUserRouteDto $changeUserRouteDto
     * @return RouteDto
     */
    public function addRouteToUserFavorite(ChangeUserRouteDto $changeUserRouteDto): RouteDto
    {
        /** @var UserFavoriteRoute $userFavoriteRoute */
        $userFavoriteRoute = UserFavoriteRoute::query()->create([
            'user_id' => $changeUserRouteDto->userId,
            'route_id' => $changeUserRouteDto->routeId,
        ]);

        return RouteDtoMapper::fromRouteModel($userFavoriteRoute->route);
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
            ->where([
                'route_id' => $routeId,
                'user_id' => $userId
            ]);

        if ($route->get()->isEmpty()) {
            throw new RouteNotFound();
        }

        $route->delete();
    }

    /**
     * @param string $routeName
     * @return bool
     */
    public function isExistByName(string $routeName): bool
    {
        return (boolean) $this->model->query()->where('name', $routeName)->first();
    }
}
