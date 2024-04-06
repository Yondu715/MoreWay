<?php

namespace App\Infrastructure\Http\Resources\Place;

use App\Application\DTO\Out\Place\LocalityDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin LocalityDto
 */
class LocalityResource extends  JsonResource
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
            'name' => $this->name,
        ];
    }
}
