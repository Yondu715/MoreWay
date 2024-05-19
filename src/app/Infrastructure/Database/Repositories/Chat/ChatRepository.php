<?php

namespace App\Infrastructure\Database\Repositories\Chat;

use App\Application\Contracts\Out\Repositories\Chat\IChatRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Chat\CreateChatDto;
use App\Application\DTO\In\Chat\GetUserChatsDto;
use App\Application\DTO\Out\Chat\ChatDto;
use App\Application\Exceptions\Chat\FailedToCreateChat;
use App\Infrastructure\Database\Models\Chat;
use App\Infrastructure\Database\Models\ChatActiveRoute;
use App\Infrastructure\Database\Models\ChatMember;
use App\Infrastructure\Database\Transaction\Interface\ITransactionManager;
use App\Utils\Mappers\Out\Chat\ChatDtoMapper;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class ChatRepository implements IChatRepository
{
    private readonly Model $model;

    public function __construct(
        private readonly ITransactionManager $transactionManager,
        Chat $chat
    )
    {
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
            })->cursorPaginate(perPage: $getUserChatsDto->limit , cursor: $getUserChatsDto->cursor);
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

            ChatActiveRoute::query()->create([
                'chat_id' => $chat->id,
                'route_id' => $createChatDto->routeId,
            ]);

            foreach ($createChatDto->members as $member) {
                ChatMember::query()->create([
                    'chat_id' => $chat->id,
                    'user_id' => $member,
                ]);
            }

            ChatMember::query()->create([
                'chat_id' => $chat->id,
                'user_id' => $createChatDto->creatorId,
            ]);

            $chatDto = ChatDtoMapper::fromChatModel($chat);

            $this->transactionManager->commit();

            return $chatDto;
        } catch (Throwable) {
            $this->transactionManager->rollback();
            throw new FailedToCreateChat();
        }
    }
}
