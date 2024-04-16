<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Resources\Route;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Resources\Auth\UserResource;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Resources\Route\Point\PointResource;
use Illuminate\Http\Request;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Route\RouteDto;
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
            'routePoints' => $this->points->map(function ($point) {
                return PointResource::make($point);
            }),
            'creator' => UserResource::make($this->creator)
        ];
    }
}
