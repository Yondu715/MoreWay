<?php

namespace App\Infrastructure\Http\Resources\Review;

use App\Application\DTO\Collection\CursorDto;
use App\Infrastructure\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CursorDto
 */
class ReviewCursorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => ReviewResource::collection($this->data),
            'meta' => [
                'cursor' => $this->cursor
            ]
        ];
    }
}
