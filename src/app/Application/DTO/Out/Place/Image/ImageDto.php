<?php

namespace App\Application\DTO\Out\Place\Image;

use App\Infrastructure\Database\Models\PlaceImage;
use Illuminate\Support\Collection;

class ImageDto
{
    public readonly int $id;
    public readonly string $path;

    public function __construct(
        int $id,
        string $path,
    ) {
        $this->id = $id;
        $this->path = $path;
    }

    /**
     * @param Collection<int, PlaceImage> $placeImages
     * @return Collection<int, PlaceImage>
     */
    public static function fromImageCollection(Collection $placeImages): Collection
    {
        return $placeImages->map(function ($placeImage) {
            return new self(
                id: $placeImage->id,
                path: $placeImage->image,
            );
        });
    }
}
