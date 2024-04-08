<?php

namespace App\Infrastructure\Http\Resources\Place\Review;

use App\Application\DTO\Out\Place\Review\PlaceReviewDto;
use App\Infrastructure\Http\Resources\Auth\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin PlaceReviewDto
 */
class PlaceReviewResource extends JsonResource
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
            'createdAt' => $this->created_at,
            'author' => UserResource::make($this->author),
        ];
    }
}
