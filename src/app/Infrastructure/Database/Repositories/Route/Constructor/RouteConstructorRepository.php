<?php

namespace App\Infrastructure\Database\Repositories\Route\Constructor;

use App\Application\Contracts\Out\Repositories\Route\Constructor\IRouteConstructorRepository;
use App\Application\DTO\In\Route\Constructor\ChangeUserRouteConstructorDto;
use App\Application\DTO\In\Route\Constructor\GetUserRouteConstructorDto;
use App\Application\DTO\Out\Route\Constructor\RouteConstructorDto;
use App\Application\Exceptions\Route\Constructor\ConstructorNotFound;
use App\Application\Exceptions\Route\Constructor\InvalidRoutePointIndex;
use App\Infrastructure\Database\Models\RouteConstructor;
use App\Infrastructure\Database\Models\RouteConstructorPoint;
use App\Infrastructure\Database\Transaction\Interface\ITransactionManager;
use App\Utils\Mappers\Out\Route\Constructor\ConstructorDtoMapper;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class RouteConstructorRepository implements IRouteConstructorRepository
{
    private readonly Model $model;

    public function __construct(
        private readonly ITransactionManager $transactionManager,
        RouteConstructor $routeConstructor
    )
    {
        $this->model = $routeConstructor;
    }

    /**
     * @param ChangeUserRouteConstructorDto $changeUserRouteConstructorDto
     * @param Closure $distanceCalculator
     * @return RouteConstructorDto
     * @throws ConstructorNotFound
     * @throws InvalidRoutePointIndex
     * @throws Throwable
     */
    public function update(ChangeUserRouteConstructorDto $changeUserRouteConstructorDto, Closure $distanceCalculator): RouteConstructorDto
    {
        try {
            $this->transactionManager->beginTransaction();

            /** @var ?RouteConstructor $routeConstructor */
            $routeConstructor = $this->model->query()->firstOrCreate([
                'creator_id' => $changeUserRouteConstructorDto->userId
            ]);

            $routePoints = collect($changeUserRouteConstructorDto->routePoints)->sortBy('index')->values();

            RouteConstructorPoint::query()->where('constructor_id', $routeConstructor->id)->forceDelete();

            $routePoints->each(function ($routePoint, $index) use ($routeConstructor) {
                if ($routePoint->index !== $index + 1) {
                    throw new InvalidRoutePointIndex();
                }

                RouteConstructorPoint::query()->create([
                    'index' => $routePoint->index,
                    'constructor_id' => $routeConstructor->id,
                    'place_id' => $routePoint->placeId,
                ]);
            });

            RouteConstructorPoint::query()
                ->where('constructor_id', $routeConstructor->id)
                ->whereNotIn('index', $routePoints->pluck('index'))
                ->forceDelete();

            $this->transactionManager->commit();

            return ConstructorDtoMapper::fromRouteConstructorModel($routeConstructor, $distanceCalculator);
        } catch (Throwable $th) {
            $this->transactionManager->rollback();
            throw $th;
        }
    }

    /**
     * @param GetUserRouteConstructorDto $getUserRouteConstructorDto , Closure $distanceCalculator
     * @param Closure $distanceCalculator
     * @return RouteConstructorDto
     */
    public function findByUserId(GetUserRouteConstructorDto $getUserRouteConstructorDto, Closure $distanceCalculator): RouteConstructorDto
    {
        /** @var RouteConstructor $constructor */
        $constructor = $this->model->query()->firstOrCreate([
            'creator_id' => $getUserRouteConstructorDto->userId
        ]);
        return ConstructorDtoMapper::fromRouteConstructorModel(
            $constructor, $distanceCalculator
        );
    }
}
