<?php

namespace App\Infrastructure\Http\Resources\Route;

use App\Application\DTO\Collection\CursorDto;
use App\Infrastructure\Http\Resources\Auth\UserResource;
use App\Infrastructure\Http\Resources\Route\Point\PointResource;
use http\Client\Curl\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/**
 * @mixin CursorDto
 */
class RouteCursorResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->data->map(function ($resource) {
                return [
                    'id' => $resource->id,
                    'name' => $resource->name,
                    'rating' => $resource->rating,
                    'points' => PointResource::collection($resource->points),
                    'creator' => UserResource::make($resource->creator)
                ];
            }),
            'meta' => [
                'next_cursor' => $this->next_cursor
            ]
        ];
    }
}
