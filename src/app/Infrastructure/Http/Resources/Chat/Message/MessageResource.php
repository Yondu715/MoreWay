<?php

namespace App\Infrastructure\Http\Resources\Chat\Message;

use App\Application\DTO\Out\Chat\Message\MessageDto;
use App\Infrastructure\Http\Resources\Auth\ShortUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin MessageDto
 */
class MessageResource extends JsonResource
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
            'message' => $this->message,
            'createdAt' => $this->createdAt,
            'sender' => ShortUserResource::make($this->sender)
        ];
    }
}
