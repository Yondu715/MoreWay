<?php

namespace App\Application\DTO\Out\Route;

use App\Application\DTO\Collection\CursorDto;
use Illuminate\Contracts\Pagination\CursorPaginator;

class RouteCursorDto extends CursorDto
{
    /**
     * @param CursorPaginator $paginator
     * @return CursorDto
     */
    public static function fromPaginator(CursorPaginator $paginator): CursorDto
    {
        return CursorDto::fromPaginatorAndMapper($paginator, function ($route){
            return RouteDto::fromRouteModel($route);
        });
    }
}
