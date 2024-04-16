<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Resources\Place;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Place\PlaceDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Resources\Place\Image\ImageResource;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Resources\Place\Locality\LocalityResource;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Resources\Place\Type\TypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin PlaceDto
 */
class PlaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'distance' => $this->distance,
            'id' => $this->id,
            'name' => $this->name,
            'lat' => $this->lat,
            'lon' => $this->lon,
            'rating' => $this->rating,
            'description' => $this->description,
            'images' => $this->images->map(function ($image) {
                return ImageResource::make($image);
            }),
            'locality' => LocalityResource::make($this->locality),
            'type' => TypeResource::make($this->type)
        ];
    }
}
