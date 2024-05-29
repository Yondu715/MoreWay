<?php

namespace App\Application\Services\Rating;

use App\Application\DTO\Out\Rating\RatingDto;
use App\Application\DTO\In\Rating\GetRatingDto;
use App\Application\DTO\Out\Rating\LeaderBoardDto;
use App\Application\DTO\Out\Rating\ExtendedRatingDto;
use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Application\Contracts\In\Services\Rating\IRatingService;
use App\Application\Contracts\Out\Repositories\Rating\IRatingRepository;

class RatingService implements IRatingService
{
    public function __construct(
        private readonly IRatingRepository $ratingRepository,
        private readonly ITokenManager $tokenManager
    ) {
    }

    /**
     * @param GetRatingDto $getRatingDto
     * @return LeaderBoardDto
     */
    public function getRating(GetRatingDto $getRatingDto): LeaderBoardDto
    {
        $ratings = $this->ratingRepository->getAll($getRatingDto);

        $extendedRatings = $ratings->map(fn (RatingDto $ratingDto, int $index) => new ExtendedRatingDto(
            user: $ratingDto->user,
            score: $ratingDto->score,
            position: $index + 1
        ));

        return new LeaderBoardDto(
            $extendedRatings->take(5),
            $extendedRatings->first(
                fn (ExtendedRatingDto $extendedRatingDto) =>
                $extendedRatingDto->user->id === $this->tokenManager->getAuthUser()->id
            )
        );
    }
}
