<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Route;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Auth\UserDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Route\Point\PointDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\Route;
use Illuminate\Support\Collection;

class RouteDto
{
    public readonly int $id;
    public readonly string $name;
    public readonly Collection $points;
    public readonly UserDto $creator;

    public function __construct(
        string $id,
        string $name,
        Collection $points,
        UserDto $creator,
    ) {

        $this->id = $id;
        $this->name = $name;
        $this->points = $points;
        $this->creator = $creator;
    }

    /**
     * @param Route $route
     * @return self
     */
    public static function fromRouteModel(Route $route): self
    {
        return new self(
            id: $route->id,
            name: $route->name,
            points: PointDto::fromPointCollection($route->routePoints),
            creator: UserDto::fromUserModel($route->creator)
        );
    }
}

