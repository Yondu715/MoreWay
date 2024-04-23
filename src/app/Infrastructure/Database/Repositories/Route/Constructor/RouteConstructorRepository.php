<?php

namespace App\Infrastructure\Database\Repositories\Route\Constructor;

use App\Application\Contracts\Out\Repositories\Route\Constructor\IRouteConstructorRepository;
use App\Application\DTO\In\Route\Constructor\RouteConstructorDto as InRouteConstructorDto;
use App\Application\DTO\Out\Route\Constructor\RouteConstructorDto as OutRouteConstructorDto;
use App\Application\Exceptions\Route\Constructor\ConstructorNotFound;
use App\Application\Exceptions\Route\Constructor\InvalidRoutePointIndex;
use App\Infrastructure\Database\Models\RouteConstructor;
use App\Infrastructure\Database\Models\RouteConstructorPoint;
use App\Infrastructure\Database\Transaction\Interface\ITransactionManager;
use App\Utils\Mappers\Out\Route\Constructor\ConstructorDtoMapper;
use Throwable;

class RouteConstructorRepository implements IRouteConstructorRepository
{
    public function __construct(
        private readonly ITransactionManager $transactionManager
    ) {
    }

    /**
     * @param RouteConstructorDto $routeConstructorDto
     * @return ConstructorRouteConstructorDto
     * @throws InvalidRoutePointIndex
     * @throws Throwable
     */
    public function update(InRouteConstructorDto $routeConstructorDto): OutRouteConstructorDto
    {
        try {
            /** @var ?RouteConstructor $routeConstructor */
            $routeConstructor = RouteConstructor::query()
                ->where('creator_id', $routeConstructorDto->userId)
                ->first();

            if (!$routeConstructor) {
                throw new ConstructorNotFound();
            }

            $this->transactionManager->beginTransaction();
            $routePoints = collect($routeConstructorDto->routePoints)->sortBy('index')->values();

            $routePoints->each(function ($routePoint, $index) use ($routeConstructor) {
                if ($routePoint->index !== $index + 1) {
                    throw new InvalidRoutePointIndex();
                }
                RouteConstructorPoint::query()->updateOrCreate([
                    'index' => $routePoint->index,
                    'constructor_id' => $routeConstructor->id,
                ], [
                    'place_id' => $routePoint->placeId,
                ]);
            });

            RouteConstructorPoint::query()
                ->where('constructor_id', $routeConstructor->id)
                ->whereNotIn('index', $routePoints->pluck('index'))
                ->forceDelete();

            $this->transactionManager->commit();

            return ConstructorDtoMapper::fromRouteConstructorModel($routeConstructor);
        } catch (Throwable $th) {
            $this->transactionManager->rollback();
            throw $th;
        }
    }

    /**
     * @param int $userId
     * @return OutRouteConstructorDto
     */
    public function findByUserId(int $userId): OutRouteConstructorDto
    {
        return ConstructorDtoMapper::fromRouteConstructorModel(
            RouteConstructor::query()->firstOrCreate([
                'creator_id' => $userId
            ])
        );
    }
}
