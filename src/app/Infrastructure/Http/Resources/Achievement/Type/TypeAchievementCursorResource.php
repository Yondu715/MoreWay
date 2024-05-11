<?php

namespace App\Infrastructure\Http\Resources\Achievement\Type;

use App\Application\DTO\Collection\CursorDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CursorDto
 */
class TypeAchievementCursorResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => TypeAchievementResource::collection($this->data),
            'meta' => [
                'next_cursor' => $this->next_cursor
            ]
        ];
    }
}
