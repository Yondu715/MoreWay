<?php

namespace App\Application\DTO\In\Route;

use App\Infrastructure\Http\Requests\Route\CreateRouteRequest;

class CreateRouteDto
{
    public readonly int $creatorId;
    public readonly string $name;
    public readonly array $routePoints;

    public function __construct(
        int $creatorId,
        string $name,
        array $routePoints
    ) {
        $this->creatorId = $creatorId;
        $this->name = $name;
        $this->routePoints = $routePoints;
    }

    public static function fromRequest(CreateRouteRequest $createRouteRequest): self
    {
        return new self(
            creatorId: $createRouteRequest->creatorId,
            name: $createRouteRequest->name,
            routePoints: RoutePointDto::fromArray($createRouteRequest->routePoints)
        );
    }
}
