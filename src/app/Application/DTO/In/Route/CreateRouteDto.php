<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Route;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Route\Point\PointDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Requests\Route\CreateRouteRequest;

class CreateRouteDto
{
    public readonly int $userId;
    public readonly string $name;
    public readonly array $routePoints;

    public function __construct(
        int $userId,
        string $name,
        array $routePoints
    ) {
        $this->userId = $userId;
        $this->name = $name;
        $this->routePoints = $routePoints;
    }

    public static function fromRequest(CreateRouteRequest $createRouteRequest): self
    {
        return new self(
            userId: $createRouteRequest->userId,
            name: $createRouteRequest->name,
            routePoints: PointDto::fromArray($createRouteRequest->routePoints)
        );
    }
}
