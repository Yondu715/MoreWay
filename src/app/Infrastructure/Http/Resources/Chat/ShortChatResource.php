<?php

namespace App\Infrastructure\Http\Resources\Chat;

use App\Application\DTO\Out\Chat\ChatDto;
use App\Infrastructure\Http\Resources\Chat\Message\MessageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ChatDto
 */
class ShortChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'isActive' => $this->isActive,
            'lastMessage' => count($this->messages) ? MessageResource::make($this->messages->last()) : null,
        ];
    }
}
