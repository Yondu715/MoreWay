<?php

namespace App\Utils\Mappers\Out\Place\Image;

use App\Application\DTO\Out\Place\Image\ImageDto;
use App\Infrastructure\Database\Models\PlaceImage;
use Illuminate\Support\Collection;

class ImageDtoMapper
{
    /**
     * @param Collection<int, PlaceImage> $placeImages
     * @return Collection<int, ImageDto>
     */
    public static function fromImageCollection(Collection $placeImages): Collection
    {
        return $placeImages->map(function (PlaceImage $placeImage) {
            return new ImageDto(
                id: $placeImage->id,
                path: $placeImage->image,
            );
        });
    }
}