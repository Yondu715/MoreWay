<?php

namespace App\Infrastructure\Http\Resources\Route\Point;

use App\Application\DTO\Out\Route\Point\PointDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin PointDto
 */
class ShortPointResource extends JsonResource
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
            'image' => !$this->place->images->isEmpty() ? url("/storage/{$this->place->images->first()->path}") : null,
        ];
    }
}
