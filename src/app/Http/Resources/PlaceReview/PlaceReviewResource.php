<?php

namespace App\Http\Resources\PlaceReview;

use App\Models\PlaceReview;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin PlaceReview
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
            'author' => [
                'id' =>  $this->author->id,
                'name' => $this->author->name,
                'avatar' => $this->author->avatar
            ],
        ];
    }
}
