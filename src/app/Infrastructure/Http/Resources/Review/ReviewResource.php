<?php

namespace App\Infrastructure\Http\Resources\Review;

use App\Application\DTO\Out\Review\ReviewDto;
use App\Infrastructure\Http\Resources\Auth\ShortUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ReviewDto
 */
class ReviewResource extends JsonResource
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
            'text' => $this->text,
            'rating' => $this->rating,
            'createdAt' => $this->createdAt,
            'author' => ShortUserResource::make($this->author),
        ];
    }
}
