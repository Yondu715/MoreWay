<?php

namespace App\Infrastructure\Http\Resources\Route;

use App\Application\DTO\Out\Route\ActiveRouteDto;
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
            'isGroup' => $this->isGroup,
            'route' => RouteResource::make($this->route),
        ];
    }
}
