<?php

namespace App\Infrastructure\Http\Resources\Route;

use App\Application\DTO\Out\Route\ActiveRouteDto;
use App\Infrastructure\Http\Resources\Route\Point\ActivePointResource;
use App\Infrastructure\Http\Resources\User\ShortUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ActiveRouteDto
 */
class UserActiveRouteResource  extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->route->id,
            'name' => $this->route->name,
            'isGroup' => $this->isGroup,
            'rating' => $this->route->rating,
            'routePoints' => ActivePointResource::collection($this->route->points),
            'creator' => ShortUserResource::make($this->route->creator)
        ];
    }
}
