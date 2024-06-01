<?php

namespace App\Application\Services\Rating;

use App\Application\DTO\In\Rating\GetRatingDto;
use App\Application\DTO\Out\Rating\LeaderBoardDto;
use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Application\Contracts\In\Services\Rating\IRatingService;
use App\Application\Contracts\Out\Repositories\Rating\IRatingRepository;
use App\Infrastructure\Exceptions\InvalidToken;

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
     * @throws InvalidToken
     */
    public function getRating(GetRatingDto $getRatingDto): LeaderBoardDto
    {
        $leaders = $this->ratingRepository->getLeaders();
        $userRating = $this->ratingRepository->getRatingByUserId($this->tokenManager->getAuthUser()->user->id);

        return new LeaderBoardDto(
            $leaders,
            $userRating
        );
    }
}
