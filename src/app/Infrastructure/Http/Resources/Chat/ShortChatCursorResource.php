<?php

namespace App\Infrastructure\Http\Resources\Chat;

use App\Application\DTO\Collection\CursorDto;
use App\Infrastructure\Http\Resources\Rating\RatingResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CursorDto
 */
class ShortChatCursorResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => ShortChatResource::collection($this->data),
            'meta' => [
                'cursor' => $this->cursor
            ]
        ];
    }
}
