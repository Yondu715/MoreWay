<?php

namespace App\Application\Contracts\In\Services\Chat\Activity;

use App\Application\DTO\In\Chat\Activity\ChangeActivityDto;
use App\Application\DTO\Out\Route\RouteDto;
use App\Application\Exceptions\Chat\Activity\FailedToChangeActivity;
use App\Application\Exceptions\Chat\Activity\FailedToGetActivity;
use App\Infrastructure\Exceptions\InvalidToken;

interface IChatActivityService
{
    /**
     * @param int $chatId
     * @return RouteDto
     * @throws InvalidToken
     * @throws FailedToGetActivity
     */
    public function getActivity(int $chatId): RouteDto;

    /**
     * @param ChangeActivityDto $changeActivityDto
     * @return RouteDto
     * @throws InvalidToken
     * @throws FailedToChangeActivity
     */
    public function changeActivity(changeActivityDto $changeActivityDto): RouteDto;
}
