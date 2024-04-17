<?php

namespace App\Application\DTO\Out\Route;

use App\Application\DTO\Out\Auth\UserDto;
use App\Application\DTO\Out\Route\Point\PointDto;
use App\Infrastructure\Database\Models\Route;
use Illuminate\Support\Collection;

class RouteDto
{
    public readonly int $id;
    public readonly string $name;
    public readonly Collection $points;
    public readonly UserDto $creator;
    public readonly ?float $rating;

    public function __construct(
        string $id,
        string $name,
        Collection $points,
        UserDto $creator,
        float $rating
    ) {

        $this->id = $id;
        $this->name = $name;
        $this->points = $points;
        $this->creator = $creator;
        $this->rating = $rating;
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
            creator: UserDto::fromUserModel($route->creator),
            rating: $route->rating()
        );
    }
}

