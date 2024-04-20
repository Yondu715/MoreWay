<?php

namespace App\Infrastructure\Http\Resources\Route\Filter;

use App\Application\DTO\Out\Route\Filter\RouteFilterDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin RouteFilterDto
 */
class RouteFilterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'minPassing' => $this->minPassing,
            'maxPassing' => $this->maxPassing,
            'minPoint' => $this->minPoint,
            'maxPoint' => $this->maxPoint,
        ];
    }
}
