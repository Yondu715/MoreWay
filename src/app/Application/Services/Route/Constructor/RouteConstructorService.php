<?php

namespace App\Application\Services\Route\Constructor;

use App\Application\Contracts\In\Services\Route\Constructor\IRouteConstructorService;
use App\Application\Contracts\Out\Repositories\Route\Constructor\IRouteConstructorRepository;
use App\Application\DTO\In\Route\Constructor\RouteConstructorDto as InRouteConstructorDto;
use App\Application\DTO\Out\Route\Constructor\RouteConstructorDto as OutRouteConstructorDto;
use App\Application\Exceptions\Route\Constructor\InvalidRoutePointIndex;
use Throwable;

class RouteConstructorService implements IRouteConstructorService
{
    public function __construct(
        private readonly IRouteConstructorRepository $routeConstructorRepository
    ) {
    }

    /**
     * @param InRouteConstructorDto $routeConstructorDto
     * @return OutRouteConstructorDto
     * @throws InvalidRoutePointIndex
     * @throws Throwable
     */
    public function change(InRouteConstructorDto $routeConstructorDto): OutRouteConstructorDto
    {
        return $this->routeConstructorRepository->update($routeConstructorDto);
    }

    /**
     * @param int $userId
     * @return OutRouteConstructorDto
     */
    public function get(int $userId): OutRouteConstructorDto
    {
        return $this->routeConstructorRepository->findByUserId($userId);
    }
}
