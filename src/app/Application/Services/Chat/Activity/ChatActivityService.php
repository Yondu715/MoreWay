<?php

namespace App\Application\Services\Chat\Activity;

use App\Application\Contracts\In\Services\Chat\Activity\IChatActivityService;
use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Application\Contracts\Out\Repositories\Chat\IChatRepository;
use App\Application\DTO\In\Chat\Activity\ChangeActivityDto;
use App\Application\DTO\Out\Route\RouteDto;
use App\Application\Exceptions\Chat\Activity\FailedToChangeActivity;
use App\Application\Exceptions\Chat\Activity\FailedToGetActivity;
use App\Infrastructure\Exceptions\Forbidden;
use App\Infrastructure\Exceptions\InvalidToken;

class ChatActivityService implements IChatActivityService
{
    public function __construct(
        private readonly IChatRepository $chatRepository,
        private readonly ITokenManager $tokenManager,
        private readonly INotifierManager $notifier
    ) {}

    /**
     * @param int $chatId
     * @return RouteDto
     * @throws InvalidToken
     * @throws FailedToGetActivity
     */
    public function getActivity(int $chatId): RouteDto
    {
        return $this->chatRepository->getActivity($chatId, $this->tokenManager->getAuthUser()->id);
    }

    /**
     * @param ChangeActivityDto $changeActivityDto
     * @return RouteDto
     * @throws InvalidToken
     * @throws FailedToChangeActivity
     * @throws Forbidden
     */
    public function changeActivity(changeActivityDto $changeActivityDto): RouteDto
    {
        $activity = $this->chatRepository->changeActivity($changeActivityDto, $this->tokenManager->getAuthUser()->id);

        foreach ($this->chatRepository->getChat($changeActivityDto->chatId, $this->tokenManager->getAuthUser()->id)->members as $member) {
            if($member->id !== $this->tokenManager->getAuthUser()->id) {
                $this->notifier->sendNotification($member->id, $activity);
            }
        }

        return $activity;
    }
}
