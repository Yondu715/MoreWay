<?php

namespace App\Infrastructure\Http\Resources\Route;

use App\Infrastructure\Http\Resources\User\ShortUserResource;
use App\Infrastructure\Http\Resources\Route\Point\ShortPointResource;
use Illuminate\Http\Request;
use App\Application\DTO\Out\Route\RouteDto;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin RouteDto
 */
class ShortRouteResource extends JsonResource
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
            'places' => $this->points->count(),
            'routePoints' => ShortPointResource::collection($this->points),
            'creator' => ShortUserResource::make($this->creator)
        ];
    }
}
