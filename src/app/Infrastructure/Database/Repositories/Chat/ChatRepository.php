<?php

namespace App\Infrastructure\Database\Repositories\Chat;

use Throwable;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Application\DTO\Out\Chat\ChatDto;
use App\Application\DTO\Out\User\UserDto;
use App\Application\DTO\Out\Route\RouteDto;
use App\Infrastructure\Database\Models\Chat;
use App\Infrastructure\Exceptions\Forbidden;
use App\Application\DTO\Collection\CursorDto;
use App\Utils\Mappers\Out\Chat\ChatDtoMapper;
use App\Utils\Mappers\Out\User\UserDtoMapper;
use App\Application\DTO\In\Chat\CreateChatDto;
use App\Utils\Mappers\Out\Route\RouteDtoMapper;
use App\Application\DTO\In\Chat\GetUserChatsDto;
use App\Application\Exceptions\Chat\ChatNotFound;
use App\Infrastructure\Database\Models\ChatMember;
use App\Application\DTO\In\Chat\Member\AddMembersDto;
use App\Application\Exceptions\Chat\FailedToCreateChat;
use App\Infrastructure\Database\Models\ChatActiveRoute;
use App\Application\DTO\In\Chat\Activity\ChangeActivityDto;
use App\Application\Exceptions\Chat\Members\FailedToAddMembers;
use App\Application\Exceptions\Chat\Activity\FailedToGetActivity;
use App\Application\Exceptions\Chat\Members\FailedToDeleteMember;
use App\Application\Contracts\Out\Repositories\Chat\IChatRepository;
use App\Application\Exceptions\Chat\Activity\FailedToChangeActivity;
use App\Infrastructure\Database\Transaction\Interface\ITransactionManager;

class ChatRepository implements IChatRepository
{
    private readonly Model $model;

    public function __construct(
        private readonly ITransactionManager $transactionManager,
        Chat $chat
    ) {
        $this->model = $chat;
    }

    /**
     * @param GetUserChatsDto $getUserChatsDto
     * @return CursorDto
     */
    public function getUserChats(GetUserChatsDto $getUserChatsDto): CursorDto
    {
        $paginator = $this->model::query()
            ->whereHas('members', function ($query) use ($getUserChatsDto) {
                $query->where('user_id', $getUserChatsDto->userId);
            })->cursorPaginate(perPage: $getUserChatsDto->limit, cursor: $getUserChatsDto->cursor);
        return ChatDtoMapper::fromPaginator($paginator);
    }

    /**
     * @param CreateChatDto $createChatDto
     * @return ChatDto
     * @throws FailedToCreateChat
     */
    public function create(CreateChatDto $createChatDto): ChatDto
    {
        try {
            $this->transactionManager->beginTransaction();

            /** @var Chat $chat */
            $chat = $this->model->query()->create([
                'name' => $createChatDto->name,
                'creator_id' => $createChatDto->creatorId,
            ]);

            $chat->activeRoute()->create([
                'route_id' => $createChatDto->routeId
            ]);

            $chat->users()->attach([...$createChatDto->members, $createChatDto->creatorId]);

            $chatDto = ChatDtoMapper::fromChatModel($chat);

            $this->transactionManager->commit();

            return $chatDto;
        } catch (Throwable) {
            $this->transactionManager->rollback();
            throw new FailedToCreateChat();
        }
    }

    /**
     * @param int $chatId
     * @param int $userId
     * @return ChatDto
     * @throws Forbidden
     */
    public function getChat(int $chatId, int $userId): ChatDto
    {
        try {
            /** @var Chat $chat */
            $chat = $this->model::query()->where('id', $chatId)
                ->whereHas('members', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })->firstOrFail();

            return ChatDtoMapper::fromChatModel($chat);
        } catch (Throwable) {
            throw new Forbidden();
        }
    }

    /**
     * @param int $chatId
     * @return ChatDto
     * @throws ChatNotFound
     */
    public function findById(int $chatId): ChatDto
    {
        try {
            /** @var Chat $chat */
            $chat = $this->model->query()->findOrFail($chatId);
            return ChatDtoMapper::fromChatModel($chat);
        } catch (Throwable) {
            throw new ChatNotFound();
        }
    }

    /**
     * @param AddMembersDto $addMembersDto
     * @return Collection<int, UserDto>
     * @throws FailedToAddMembers
     */
    public function createMembers(AddMembersDto $addMembersDto): Collection
    {
        try {

            $members = new Collection();

            $this->transactionManager->beginTransaction();

            foreach ($addMembersDto->members as $member) {
                $members->add(ChatMember::query()->create([
                    'chat_id' => $addMembersDto->chatId,
                    'user_id' => $member,
                ]));
            }

            $this->transactionManager->commit();

            return UserDtoMapper::fromChatMemberCollection($members);
        } catch (Throwable) {
            $this->transactionManager->rollBack();
            throw new FailedToAddMembers();
        }
    }

    /**
     * @param int $chatId
     * @param int $memberId
     * @return bool
     * @throws FailedToDeleteMember
     */
    public function deleteMember(int $chatId, int $memberId): bool
    {
        try {
            return ChatMember::query()->where([
                'chat_id' => $chatId,
                'user_id' => $memberId
            ])->firstOrFail()->delete();
        } catch (Throwable) {
            throw new FailedToDeleteMember();
        }
    }

    /**
     * @param int $chatId
     * @return RouteDto
     * @throws FailedToGetActivity
     */
    public function getActivity(int $chatId): RouteDto
    {
        try {
            /** @var Chat $chat */
            $chat = $this->model->query()->with(['activeRoute, activeRoute.route'])->findOrFail($chatId);
            return RouteDtoMapper::fromRouteModel($chat->activeRoute->route);
        } catch (Throwable) {
            throw new FailedToGetActivity();
        }
    }

    /**
     * @param ChangeActivityDto $changeActivityDto
     * @return RouteDto
     * @throws FailedToChangeActivity
     */
    public function changeActivity(ChangeActivityDto $changeActivityDto): RouteDto
    {
        try {
            /** @var ChatActiveRoute $activity */
            $activity = ChatActiveRoute::query()->where('chat_id', $changeActivityDto->chatId)->first();

            $activity->update([
                'route_id' => $changeActivityDto->routeId,
            ]);

            return RouteDtoMapper::fromRouteModel($activity->route);
        } catch (Throwable) {
            throw new FailedToChangeActivity();
        }
    }
}
