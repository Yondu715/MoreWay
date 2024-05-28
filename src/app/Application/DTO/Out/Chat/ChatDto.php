<?php

namespace App\Application\DTO\Out\Chat;

use App\Application\DTO\Out\User\UserDto;
use App\Application\DTO\Out\Route\RouteDto;
use Illuminate\Support\Collection;

class ChatDto
{
    public readonly int $id;
    public readonly string $name;
    public readonly bool $isActive;
    public readonly UserDto $creator;
    public readonly Collection $members;
    public readonly Collection $messages;
    public readonly RouteDto $activity;

    public function __construct(
        int        $id,
        string     $name,
        bool       $isActive,
        UserDto    $creator,
        Collection $members,
        Collection $messages,
        RouteDto   $activity,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->isActive = $isActive;
        $this->creator = $creator;
        $this->members = $members;
        $this->messages = $messages;
        $this->activity = $activity;
    }
}
