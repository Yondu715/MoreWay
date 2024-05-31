<?php

namespace App\Application\Enums\Route;

enum RouteRestriction: int
{
    case MIN_ROUTE_ITEMS = 2;
    case MAX_ROUTE_ITEMS = 15;
}