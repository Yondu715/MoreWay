<?php

namespace App\Infrastructure\Http\Resources\User;

use App\Application\DTO\Collection\CursorDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CursorDto
 */
class ExtendedUserCursorResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'data' => ExtendedUserResource::collection($this->data),
            'meta' => [
                'cursor' => $this->cursor
            ]
        ];
    }
}
