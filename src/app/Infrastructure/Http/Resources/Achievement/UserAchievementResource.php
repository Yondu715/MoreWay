<?php

namespace App\Infrastructure\Http\Resources\Achievement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAchievementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            AchievementResource::make($this->achievement),
            'currentProgress' => $this->currentProgress
        ];
    }
}
