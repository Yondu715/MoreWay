<?php

namespace App\Infrastructure\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExtendedUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => ShortUserResource::make($this->user),
            'relationship' => $this->relationship,
        ];
    } 
}