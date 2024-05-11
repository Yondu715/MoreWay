<?php

namespace App\Application\Services\Rating;

use App\Application\Contracts\In\Services\Rating\IRatingService;
use App\Application\Contracts\Out\Repositories\Rating\IRatingRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Rating\GetRatingDto;

class RatingService implements IRatingService
{
    public function __construct(
        private readonly IRatingRepository $ratingRepository,
    ) {}

    /**
     * @param GetRatingDto $getRatingDto
     * @return CursorDto
     */
    public function getRating(GetRatingDto $getRatingDto): CursorDto
    {
        return $this->ratingRepository->getAll($getRatingDto);
    }
}
