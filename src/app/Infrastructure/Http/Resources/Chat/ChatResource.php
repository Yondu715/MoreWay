<?php

namespace App\Infrastructure\Http\Resources\Chat;

use App\Application\DTO\Out\Chat\ChatDto;
use App\Infrastructure\Http\Resources\User\ShortUserResource;
use App\Infrastructure\Http\Resources\Route\ShortRouteResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/**
 * @mixin ChatDto
 */
class ChatResource extends JsonResource
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
            'creator' => ShortUserResource::make($this->creator),
            'members' => ShortUserResource::collection($this->members),
            'activity' => ShortRouteResource::make($this->activity),
        ];
    }
}
