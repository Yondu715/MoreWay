<?php

namespace App\Application\Contracts\Out\Repositories\Rating;

use Illuminate\Support\Collection;
use App\Application\DTO\Out\Rating\RatingDto;

interface IRatingRepository
{

    /**
     * @return Collection<int, RatingDto>
     */
    public function getLeaders(): Collection;

    /**
     * @param int $userId
     * @return RatingDto
     */
    public function getRatingByUserId(int $userId): RatingDto;
}
