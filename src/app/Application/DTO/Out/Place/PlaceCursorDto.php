<?php

namespace App\Application\DTO\Out\Place;

use App\Application\DTO\Collection\CursorDto;
use Illuminate\Contracts\Pagination\CursorPaginator;

class PlaceCursorDto extends CursorDto
{
    /**
     * @param CursorPaginator $paginator
     * @return CursorDto
     */
    public static function fromPaginator(CursorPaginator $paginator): CursorDto
    {
        return CursorDto::fromPaginatorAndMapper($paginator, function ($place){
            return PlaceDto::fromPlaceModel($place);
        });
    }
}
