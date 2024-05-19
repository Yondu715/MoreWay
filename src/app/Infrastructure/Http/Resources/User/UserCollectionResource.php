<?php

namespace App\Infrastructure\Http\Resources\User;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCollectionResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => ShortUserResource::collection($this),
        ];
    }
}
