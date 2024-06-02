<?php

namespace App\Infrastructure\Http\Resources\Place;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Application\DTO\Out\Place\ExtendedPlaceDto;


/**
 * @mixin ExtendedPlaceDto
 */
class ExtendedPlaceResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'place' => PlaceResource::make($this->place),
            'isInConstructor' => $this->isInConstructor
        ];
    }
}