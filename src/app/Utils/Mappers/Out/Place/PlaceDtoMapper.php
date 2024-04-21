<?php

namespace App\Utils\Mappers\Out\Place;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\Out\Place\PlaceDto;
use App\Infrastructure\Database\Models\Place;
use App\Utils\Mappers\Collection\CursorDtoMapper;
use App\Utils\Mappers\Out\Place\Image\ImageDtoMapper;
use App\Utils\Mappers\Out\Place\Locality\LocalityDtoMapper;
use App\Utils\Mappers\Out\Place\Type\PlaceTypeDtoMapper;
use Illuminate\Pagination\CursorPaginator;

class PlaceDtoMapper
{
    /**
     * @param Place $place
     * @param float|null $distance
     * @return PlaceDto
     */
    public static function fromPlaceModel(Place $place, float $distance = null): PlaceDto
    {
        return new PlaceDto(
            distance: $distance ?? $place->distance,
            id: $place->id,
            name: $place->name,
            lat: $place->lat,
            lon: $place->lon,
            rating: $place->rating(),
            description: $place->description,
            images: ImageDtoMapper::fromImageCollection($place->images),
            locality: LocalityDtoMapper::fromLocalityModel($place->locality),
            type: PlaceTypeDtoMapper::fromTypeModel($place->type)
        );
    }

    /**
     * @param CursorPaginator $cursorPaginator
     * @param callable $mapFunc
     * @return CursorDto
     */
    public static function fromPaginator(CursorPaginator $cursorPaginator, callable $mapFunc): CursorDto
    {
        return CursorDtoMapper::fromPaginatorAndMapper($cursorPaginator, $mapFunc);
    }
}