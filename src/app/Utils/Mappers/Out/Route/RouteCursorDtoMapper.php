<?php

namespace App\Utils\Mappers\Out\Route;

use App\Application\DTO\Collection\CursorDto;
use App\Utils\Mappers\Collection\CursorDtoMapper;
use Illuminate\Contracts\Pagination\CursorPaginator;

class RouteCursorDtoMapper
{
    /**
     * @param CursorPaginator $paginator
     * @return CursorDto
     */
    public static function fromPaginator(CursorPaginator $paginator): CursorDto
    {
        return CursorDtoMapper::fromPaginatorAndMapper($paginator, function ($route){
            return RouteDtoMapper::fromRouteModel($route);
        });
    }
}
