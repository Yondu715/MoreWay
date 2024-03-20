<?php

namespace App\Filters\Place;

use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class PlaceFilter extends AbstractFilter
{
    protected function getCallbacks(): array
    {
        return [
            'locality' => [$this, 'locality'],
            'type' => [$this, 'type'],
        ];
    }

    public function locality(Builder $builder, $value): void
    {
        $builder->whereHas('locality', function ($query) use ($value) {
            $query->where('name', $value);
        })->get();
    }

    public function type(Builder $builder, $value): void
    {
        $builder->whereHas('type', function ($query) use ($value) {
            $query->where('name', $value);
        })->get();
    }
}
