<?php

namespace App\Infrastructure\Database\Repositories\Route;

use Exception;
use Throwable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Application\DTO\Out\Route\RouteDto;
use App\Application\DTO\Collection\CursorDto;
use App\Infrastructure\Database\Models\Route;
use App\Application\DTO\In\Route\GetRoutesDto;
use App\Utils\Mappers\Out\Route\RouteDtoMapper;
use App\Application\DTO\In\Route\CreateRouteDto;
use App\Application\DTO\Out\Route\ActiveRouteDto;
use App\Application\DTO\Out\Route\Point\PointDto;
use App\Application\DTO\In\Route\GetUserRoutesDto;
use App\Infrastructure\Database\Models\RoutePoint;
use App\Application\Exceptions\Route\RouteNotFound;
use App\Utils\Mappers\Out\Route\Point\PointDtoMapper;
use App\Application\Exceptions\Route\RouteIsCompleted;
use App\Application\Exceptions\Route\RouteNameIsTaken;
use App\Infrastructure\Database\Models\UserActiveRoute;
use App\Application\DTO\In\Route\CompletedRoutePointDto;
use App\Application\Exceptions\Route\FailedToCreateRoute;
use App\Infrastructure\Database\Models\UserFavoriteRoute;
use App\Infrastructure\Database\Models\UserRouteProgress;
use App\Application\Exceptions\Route\UserHaveNotActiveRoute;
use App\Infrastructure\Database\Models\RouteConstructorPoint;
use App\Application\Exceptions\Route\Point\RoutePointNotFound;
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

            $routePoints->each(function ($routePoint) use ($route) {
                $route->routePoints()->create([
                    'index' => $routePoint->index,
                    'place_id' => $routePoint->place_id,
                ]);

                $routePoint->forceDelete();
            });

            $this->transactionManager->commit();

            return RouteDtoMapper::fromRouteModel($route->refresh());
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
            return RouteDtoMapper::fromRouteModelAndActiveFavorite($route, (bool) UserActiveRoute::query()->where([
                'route_id' => $route->id,
                'user_id' => $userId
            ])->first(), (bool) UserFavoriteRoute::query()->where([
                'route_id' => $route->id,
                'user_id' => $userId
            ])->first());
        } catch (Throwable) {
            throw new RouteNotFound();
        }
    }

    /**
     * @param int $routePointId
     * @param int $userId
     * @return ActiveRouteDto
     * @throws RouteNotFound
     */
    public function getActiveRouteByRoutePointIdAndUserId(int $routePointId, int $userId): ActiveRouteDto
    {
        try {
            /** @var RoutePoint $routePoint */
            $routePoint = RoutePoint::query()->findOrFail($routePointId);

            /** @var UserActiveRoute $route */
            $route = UserActiveRoute::query()->where([
                'route_id' => $routePoint->route->id,
                'user_id' => $userId
            ])->firstOrFail();

            return RouteDtoMapper::fromActiveRouteModel($route);
        } catch (Throwable) {
            throw new RouteNotFound();
        }
    }

    /**
     * @param int $routePointId
     * @return PointDto
     * @throws RoutePointNotFound
     */
    public function getRoutePointById(int $routePointId): PointDto
    {
        try {
            /** @var RoutePoint $routePoint */
            $routePoint = RoutePoint::query()->findOrFail($routePointId);

            return PointDtoMapper::fromPointModel($routePoint);
        } catch (Throwable) {
            throw new RoutePointNotFound();
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
     * @throws RoutePointNotFound
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
            throw new RoutePointNotFound();
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
            $activeRoute->delete();
        }
    }

    /**
     * @param GetUserRoutesDto $getUserRoutesDto
     * @return CursorDto
     */
    public function getUserRoutes(GetUserRoutesDto $getUserRoutesDto): CursorDto
    {
        $routes = $this->model->query()
            ->where('creator_id', $getUserRoutesDto->userId)
            ->cursorPaginate(perPage: $getUserRoutesDto->limit, cursor: $getUserRoutesDto->cursor);
        return RouteDtoMapper::fromPaginator($routes);
    }

    /**
     * @param int $routeId
     * @param int $creatorId
     * @return void
     */
    public function deleteRouteByRouteIdAndCreatorId(int $routeId, int $creatorId): void
    {
        $this->model->query()
            ->where([
                'id' => $routeId,
                'creator_id' => $creatorId
            ])->delete();
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
     * @throws RouteIsCompleted
     */
    public function changeActiveUserRoute(int $userId, int $routeId, bool $isGroup): ActiveRouteDto
    {
        $route = $this->model->query()
            ->where('id', $routeId)
            ->get()
            ->first();

        $userActiveRoute = UserRouteProgress::query()
            ->where('user_id', $userId)
            ->whereIn('route_point_id', $route->routePoints->pluck('id'))
            ->get();

        if (
            $userActiveRoute->where("is_completed", true)
            ->count() === $route->routePoints->count()
        ) {
            throw new RouteIsCompleted();
        }

        if (UserRouteProgress::query()
            ->where('user_id', $userId)
            ->whereIn('route_point_id', $route->routePoints->pluck('id'))
            ->get()->isEmpty()
        ) {
            $route->routePoints()->each(function ($routePoint) use ($userId) {
                UserRouteProgress::query()->create([
                    'user_id' => $userId,
                    'route_point_id' => $routePoint->id
                ]);
            });
        }

        $route = UserActiveRoute::query()
            ->updateOrCreate([
                'user_id' => $userId,
            ], [
                'route_id' =>  $routeId,
                'is_group' => $isGroup,
            ])->get()->first();
        return RouteDtoMapper::fromActiveRouteModel($route);
    }

    /**
     * @param GetUserRoutesDto $getUserRoutesDto
     * @return CursorDto
     */
    public function getFavoriteUserRoutes(GetUserRoutesDto $getUserRoutesDto): CursorDto
    {
        $favoriteRoutes = $this->model->query()
            ->whereHas('favoriteByUsers', function (Builder $builder) use ($getUserRoutesDto) {
                $builder->where('user_id', $getUserRoutesDto->userId);
            })
            ->with('routePoints')
            ->cursorPaginate(perPage: $getUserRoutesDto->limit, cursor: $getUserRoutesDto->cursor);

        return RouteDtoMapper::fromPaginator($favoriteRoutes);
    }


    /**
     * @param int $userId
     * @param int $routeId
     * @return RouteDto
     */
    public function addRouteToUserFavorite(int $userId, int $routeId): RouteDto
    {
        /** @var Route $route */
        $route = $this->model->query()->findOrFail($routeId);
        $route->favoriteByUsers()->attach($userId);

        return RouteDtoMapper::fromRouteModel($route);
    }

    /**
     * @param int $userId
     * @param int $routeId
     * @return void
     * @throws RouteNotFound
     */
    public function deleteRouteFromUserFavorite(int $userId, int $routeId): void
    {
        /** @var Route $route */
        $route = $this->model->query()->findOrFail($routeId);
        $route->favoriteByUsers()->detach($userId);
    }

    /**
     * @param string $routeName
     * @return bool
     */
    public function isExistByName(string $routeName): bool
    {
        return (bool) $this->model->query()->where('name', $routeName)->first();
    }
}
