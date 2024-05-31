<?php

namespace App\Application\Services\Chat\Vote;

use App\Application\Contracts\In\Services\Chat\Vote\IChatVoteService;
use App\Application\Contracts\Out\Managers\Cache\ICacheManager;
use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Application\Contracts\Out\Repositories\Chat\IChatRepository;
use App\Application\Contracts\Out\Repositories\Route\IRouteRepository;
use App\Application\Exceptions\Chat\ChatNotFound;
use App\Application\Exceptions\Chat\SomeMembersHaveActiveChat;
use App\Application\Exceptions\Chat\SomeMembersHaveProgressActivity;
use App\Application\Exceptions\Route\RouteIsCompleted;
use App\Infrastructure\Exceptions\InvalidToken;
use App\Infrastructure\Http\Resources\Chat\Vote\VoteResource;
use App\Utils\Mappers\Out\Vote\VoteDtoMapper;

class ChatVoteService implements IChatVoteService
{
    public function __construct(
        private readonly IChatRepository $chatRepository,
        private readonly ITokenManager $tokenManager,
        private readonly INotifierManager $notifier,
        private readonly ICacheManager $cacheManager,
        private readonly IRouteRepository $routeRepository
    ) {
    }

    /**
     * @param int $chatId
     * @return void
     * @throws ChatNotFound
     * @throws SomeMembersHaveActiveChat
     * @throws SomeMembersHaveProgressActivity
     * @throws InvalidToken
     * @throws RouteIsCompleted
     */
    public function changeVoteActivity(int $chatId): void
    {
        $chat = $this->chatRepository->findById($chatId);

        if(!$this->chatRepository->checkMembersChatNotHaveActivity($chatId)) {
            throw new SomeMembersHaveActiveChat();
        }
        if(!$this->chatRepository->checkMembersChatHaveProgressActivity($chatId)) {
            throw new SomeMembersHaveProgressActivity();
        }

        $userId = $this->tokenManager->getAuthUser()->user->id;

        $cacheKey = "ChangeVoteActivityByChatId-{$chat->id}";

        $membersIdInHolding = json_decode($this->cacheManager->get($cacheKey)) ?
            json_decode($this->cacheManager->get($cacheKey)) : [];

        if (!in_array($userId, $membersIdInHolding)
            and count($membersIdInHolding) < $chat->members->count()) {
            $membersIdInHolding[] = $userId;
            $this->cacheManager->put($cacheKey, json_encode($membersIdInHolding), 10);
            foreach ($chat->members as $member) {
                $this->notifier->sendNotification($member->id, VoteResource::make(VoteDtoMapper::fromAllAndAccepted(
                    $chat->members, $chat->members->whereIn('id', $membersIdInHolding)
                )));
            }
            if (count($membersIdInHolding) === $chat->members->count()) {
                $this->cacheManager->delete($cacheKey);
                $this->chatRepository->changeChatActive($chat->id);
                foreach ($membersIdInHolding as $memberId) {
                    $this->routeRepository->changeActiveUserRoute($memberId, $chat->activity->id, true);
                }
            }
        }
    }
}
