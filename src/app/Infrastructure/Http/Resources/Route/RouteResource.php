<?php

namespace App\Infrastructure\Http\Resources\Route;

use App\Infrastructure\Http\Resources\User\ShortUserResource;
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
            'points' => $this->points->count(),
            'isActive' => $this->isActive,
            'isFavorite' => $this->isFavorite,
            'routePoints' => PointResource::collection($this->points),
            'creator' => ShortUserResource::make($this->creator)
        ];
    }
}
