<?php

namespace App\Infrastructure\Http\Resources\User;

use App\Application\DTO\Collection\CursorDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CursorDto
 */
class UserCursorResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => ShortUserResource::collection($this->data),
            'meta' => [
                'cursor' => $this->cursor
            ]
        ];
    }
}
