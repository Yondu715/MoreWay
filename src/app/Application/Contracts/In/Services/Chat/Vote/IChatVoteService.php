<?php

namespace App\Application\Contracts\In\Services\Chat\Vote;

use App\Application\Exceptions\Chat\ChatNotFound;
use App\Application\Exceptions\Chat\SomeMembersHaveActiveChat;
use App\Application\Exceptions\Chat\SomeMembersHaveProgressActivity;
use App\Application\Exceptions\Route\RouteIsCompleted;
use App\Infrastructure\Exceptions\InvalidToken;

interface IChatVoteService
{
    /**
     * @param int $chatId
     * @return void
     * @throws ChatNotFound
     * @throws SomeMembersHaveActiveChat
     * @throws SomeMembersHaveProgressActivity
     * @throws InvalidToken
     * @throws RouteIsCompleted
     */
    public function changeVoteActivity(int $chatId): void;
}
