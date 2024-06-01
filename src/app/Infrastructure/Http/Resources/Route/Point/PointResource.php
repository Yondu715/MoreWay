<?php

namespace App\Infrastructure\Http\Resources\Route\Point;

use App\Application\DTO\Out\Route\Point\PointDto;
use App\Infrastructure\Http\Resources\Place\Image\ImageResource;
use App\Infrastructure\Http\Resources\Place\Locality\LocalityResource;
use App\Infrastructure\Http\Resources\Place\Type\TypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin PointDto
 */
class PointResource extends JsonResource
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
            'index' => $this->index,
            'place' => [
                'id' => $this->place->id,
                'name' => $this->place->name,
                'lat' => $this->place->lat,
                'lon' => $this->place->lon,
                'rating' => $this->place->rating,
                'image' => !$this->place->images->isEmpty() ? ImageResource::make($this->place->images[0]) : null,
                'locality' => LocalityResource::make($this->place->locality),
                'type' => TypeResource::make($this->place->type)
            ]
        ];
    }
}
