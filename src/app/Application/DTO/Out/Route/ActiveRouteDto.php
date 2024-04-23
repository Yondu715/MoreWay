<?php

namespace App\Application\DTO\Out\Route;

class ActiveRouteDto
{
    public readonly bool $isGroup;
    public readonly RouteDto $route;

    public function __construct(
        bool $isGroup,
        RouteDto $route,
    ) {

        $this->isGroup = $isGroup;
        $this->route= $route;
    }
}
