<?php

namespace App\Infrastructure\Http\Resources\Rating;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Infrastructure\Http\Resources\Rating\RatingResource;

class LeaderBoardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'leaders' => RatingResource::collection($this->leaders),
            'userRating' => RatingResource::make($this->userRating)
        ];
    }
}
