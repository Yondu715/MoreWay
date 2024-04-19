<?php

namespace App\Infrastructure\Http\Resources\Route;

use App\Infrastructure\Http\Resources\Auth\UserResource;
use App\Infrastructure\Http\Resources\Route\Point\PointResource;
use Illuminate\Http\Request;
use App\Application\DTO\Out\Route\RouteDto;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin RouteDto
 */
class RouteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'rating' => $this->rating,
            'routePoints' => PointResource::collection($this->points),
            'creator' => UserResource::make($this->creator)
        ];
    }
}
