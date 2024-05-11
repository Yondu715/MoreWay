<?php

namespace App\Utils\Mappers\Out\Rating;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\Out\Rating\RatingDto;
use App\Infrastructure\Database\Models\UserScore;
use App\Utils\Mappers\Collection\CursorDtoMapper;
use App\Utils\Mappers\Out\Auth\UserDtoMapper;
use Illuminate\Pagination\CursorPaginator;

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
        );
    }

    /**
     * @param CursorPaginator $paginator
     * @return CursorDto
     */
    public static function fromPaginator(CursorPaginator $paginator): CursorDto
    {
        return CursorDtoMapper::fromPaginatorAndMapper($paginator, function (UserScore $userScore) {
            return self::fromUserScoreModel($userScore);
        });
    }
}
