<?php

namespace App\Utils\Mappers\Out\Place;

use App\Application\DTO\Collection\CursorDto;
use App\Utils\Mappers\Collection\CursorDtoMapper;
use Illuminate\Support\Collection;

class PlaceCursorDtoMapper
{
    /**
     * @param Collection $places
     * @param string|null $nextCursor
     * @return CursorDto
     */
    public static function fromPaginator(Collection $places, ?string $nextCursor): CursorDto
    {
        return CursorDtoMapper::fromCollectionAndCursor($places, $nextCursor);
    }
}