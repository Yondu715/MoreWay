<?php

namespace App\Infrastructure\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExtendedUserCursorResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'data' => ExtendedUserResource::collection($this->data),
            'meta' => [
                'cursor' => $this->cursor
            ]
        ];
    }
}