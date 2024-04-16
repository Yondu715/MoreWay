<?php

namespace App\Infrastructure\Http\Resources\Place\Image;

use App\Application\DTO\Out\Place\Image\ImageDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ImageDto
 */
class ImageResource extends JsonResource
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
            'path' => 'https://more-way.ru/storage/' . $this->path,
        ];
    }
}
