<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Resources\Place;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Collection\CursorDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Resources\Place\Image\ImageResource;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Resources\Place\Locality\LocalityResource;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Resources\Place\Type\TypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CursorDto
 */
class PlaceCursorResource extends JsonResource
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
                    'distance' => $resource->distance,
                    'id' => $resource->id,
                    'name' => $resource->name,
                    'lat' => $resource->lat,
                    'lon' => $resource->lon,
                    'rating' => $resource->rating,
                    'image' => count($resource->images) ? ImageResource::make($resource->images[0]) : null,
                    'locality' => LocalityResource::make($resource->locality),
                    'type' => TypeResource::make($resource->type)
                ];
            }),
            'meta' => [
                'next_cursor' => $this->next_cursor
            ]
        ];
    }
}
