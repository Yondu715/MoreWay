<?php

namespace App\Application\DTO\Out\Route;

use App\Application\DTO\Out\User\UserDto;
use Illuminate\Support\Collection;

class RouteDto
{
    public readonly int $id;
    public readonly string $name;
    public readonly ?bool $isActive;
    public readonly ?bool $isFavorite;
    public readonly Collection $points;
    public readonly UserDto $creator;
    public readonly ?float $rating;

    public function __construct(
        int $id,
        string $name,
        Collection $points,
        UserDto $creator,
        float $rating,
        ?bool $isActive = null,
        ?bool $isFavorite = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->isActive = $isActive;
        $this->isFavorite = $isFavorite;
        $this->points = $points;
        $this->creator = $creator;
        $this->rating = $rating;
    }
}

