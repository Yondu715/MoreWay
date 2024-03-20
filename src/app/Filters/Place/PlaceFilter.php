<?php

namespace App\Filters\Place;

use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class PlaceFilter extends AbstractFilter
{
    protected function getCallbacks(): array
    {
        return [
            'locality_id' => [$this, 'locality_id'],
            'type' => [$this, 'type'],
        ];
    }

    public function locality_id(Builder $builder, $value): void
    {
        $builder->where('locality_id', $value);
    }

    public function type(Builder $builder, $value): void
    {
        $builder->where('type', $value);
    }
}
