<?php

namespace App\Infrastructure\Database\Repositories\Route\Constructor;

use App\Application\Contracts\Out\Repositories\Route\Constructor\IRouteConstructorRepository;
use App\Application\DTO\In\Route\Constructor\RouteConstructorDto;
use App\Application\Exceptions\Route\Constructor\ConstructorNotFound;
use App\Application\Exceptions\Route\Constructor\InvalidRoutePointIndex;
use App\Infrastructure\Database\Models\RouteConstructor;
use App\Infrastructure\Database\Models\RouteConstructorPoint;
use App\Infrastructure\Database\Transaction\Interface\ITransactionManager;
use Throwable;

class RouteConstructorRepository implements IRouteConstructorRepository
{
    public function __construct(
        private readonly ITransactionManager $transactionManager
    ) {}

    /**
     * @param RouteConstructorDto $routeConstructorDto
     * @return RouteConstructor
     * @throws InvalidRoutePointIndex
     * @throws Throwable
     */
    public function change(RouteConstructorDto $routeConstructorDto): RouteConstructor
    {
        try {
            /** @var RouteConstructor $routeConstructor */
            $routeConstructor = RouteConstructor::query()->where('creator_id', $routeConstructorDto->userId)->get()[0];

            if(!$routeConstructor){
                throw new ConstructorNotFound();
            }

            $this->transactionManager->beginTransaction();
            $routePoints = collect($routeConstructorDto->routePoints)->sortBy('index')->values();

            $prevIndex = 0;
            foreach ($routePoints as $routePoint) {
                if ($routePoint->index !== $prevIndex + 1) {
                    throw new InvalidRoutePointIndex();
                }
                RouteConstructorPoint::query()->updateOrCreate([
                    'index' => $routePoint->index,
                    'constructor_id' => $routeConstructor->id,
                ], [
                    'index' => $routePoint->index,
                    'place_id' => $routePoint->placeId,
                    'constructor_id' => $routeConstructor->id,
                ]);
                $prevIndex = $routePoint->index;
            }

            RouteConstructorPoint::query()->where('constructor_id', $routeConstructor->id)->whereNotIn('index', $routePoints->pluck('index'))->forceDelete();

            $this->transactionManager->commit();

            return $routeConstructor;

        } catch (Throwable $e) {
            $this->transactionManager->rollback();
            throw new InvalidRoutePointIndex();
        }
    }

    /**
     * @param int $userId
     * @return RouteConstructor
     */
    public function get(int $userId): RouteConstructor
    {
        /** @var RouteConstructor */
        return RouteConstructor::query()->firstOrCreate(['creator_id' => $userId]);
    }
}
