<?php

namespace App\Application\Services\Chat\Activity;

use App\Application\DTO\Out\Route\RouteDto;
use App\Infrastructure\Exceptions\Forbidden;
use App\Infrastructure\Exceptions\InvalidToken;
use App\Application\DTO\In\Chat\Activity\ChangeActivityDto;
use App\Application\Exceptions\Chat\Members\UserIsNotCreator;
use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Application\Exceptions\Chat\Members\UserIsNotChatMember;
use App\Application\Exceptions\Chat\Activity\FailedToGetActivity;
use App\Application\Contracts\Out\Repositories\Chat\IChatRepository;
use App\Application\Exceptions\Chat\Activity\FailedToChangeActivity;
use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use App\Application\Contracts\In\Services\Chat\Activity\IChatActivityService;

class ChatActivityService implements IChatActivityService
{
    public function __construct(
        private readonly IChatRepository $chatRepository,
        private readonly ITokenManager $tokenManager,
        private readonly INotifierManager $notifier
    ) {
    }

    /**
     * @param int $chatId
     * @return RouteDto
     * @throws InvalidToken
     * @throws UserIsNotChatMember
     * @throws FailedToGetActivity
     */
    public function getActivity(int $chatId): RouteDto
    {
        $chat = $this->chatRepository->findById($chatId);
        $member = $chat->members->first(fn ($value) => $value->id === $this->tokenManager->getAuthUser()->id);

        if (!$member) {
            throw new UserIsNotChatMember();
        }
        return $this->chatRepository->getActivity($chatId);
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
        $chat = $this->chatRepository->findById($changeActivityDto->chatId);
        $creator = $chat->members->first(fn ($value) => $value->id === $this->tokenManager->getAuthUser()->id);

        if (!$creator || $chat->creator->id !== $creator->id) {
            throw new UserIsNotCreator();
        }

        $activity = $this->chatRepository->changeActivity($changeActivityDto);

        foreach ($chat->members as $member) {
            if ($member->id !== $this->tokenManager->getAuthUser()->id) {
                $this->notifier->sendNotification($member->id, $activity);
            }
        }

        return $activity;
    }
}
