<?php

namespace App\Infrastructure\Http\Resources\Route\Point;

use App\Application\DTO\Out\Route\Point\PointDto;
use App\Infrastructure\Http\Resources\Place\Image\ImageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin PointDto
 */
class ShortPointResource extends JsonResource
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
            'image' => count($this->place->images) ? url("/storage/{$this->place->images[0]->path}") : null,
        ];
    }
}
