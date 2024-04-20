<?php

namespace App\Application\Services\Route\Constructor;

use App\Application\Contracts\In\Services\Route\Constructor\IRouteConstructorService;
use App\Application\Contracts\Out\Repositories\Route\Constructor\IRouteConstructorRepository;
use App\Application\DTO\In\Route\Constructor\RouteConstructorDto as InRouteConstructorDto;
use App\Application\DTO\Out\Route\Constructor\RouteConstructorDto as OutRouteConstructorDto;
use App\Application\Exceptions\Route\Constructor\InvalidRoutePointIndex;
use App\Utils\Mappers\Out\Route\Constructor\ConstructorDtoMapper;
use Throwable;

class RouteConstructorService implements IRouteConstructorService
{
    public function __construct(
        private readonly IRouteConstructorRepository $routeConstructorRepository
    ) {}

    /**
     * @param InRouteConstructorDto $routeConstructorDto
     * @return OutRouteConstructorDto
     * @throws InvalidRoutePointIndex
     * @throws Throwable
     */
    public function change(InRouteConstructorDto $routeConstructorDto): OutRouteConstructorDto {
        return ConstructorDtoMapper::fromRouteConstructorModel(
            $this->routeConstructorRepository->change($routeConstructorDto)
        );
    }

    /**
     * @param int $userId
     * @return OutRouteConstructorDto
     */
    public function get(int $userId): OutRouteConstructorDto
    {
        return ConstructorDtoMapper::fromRouteConstructorModel(
            $this->routeConstructorRepository->get($userId)
        );
    }
}
