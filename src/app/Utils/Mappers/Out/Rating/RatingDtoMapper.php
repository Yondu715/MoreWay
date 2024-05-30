<?php

namespace App\Utils\Mappers\Out\Rating;

use App\Application\DTO\Out\Rating\RatingDto;
use App\Utils\Mappers\Out\User\UserDtoMapper;
use App\Infrastructure\Database\Models\UserScore;

class RatingDtoMapper
{
    /**
     * @param UserScore $userScore
     * @return RatingDto
     */
    public static function fromUserScoreModel(UserScore $userScore): RatingDto
    {
        return new RatingDto(
            user: UserDtoMapper::fromUserModel($userScore->user),
            score: $userScore->score,
            position: $userScore->position
        );
    }
}
