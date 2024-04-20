<?php

namespace App\Infrastructure\Http\Resources\Route\Constructor;

use App\Application\DTO\Out\Route\Constructor\RouteConstructorDto;
use App\Infrastructure\Http\Resources\Route\Point\PointResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @mixin RouteConstructorDto
 */
class ConstructorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'routePoints' => PointResource::collection($this->points),
        ];
    }
}
