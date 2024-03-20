<?php

namespace App\Filters\Place;

use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class PlaceFilter extends AbstractFilter
{
    public const LOCALITY_ID = 'locality_id';

    protected function getCallbacks(): array
    {
        return [
            self::LOCALITY_ID => [$this, 'locality_id'],
            'type' => [$this, 'type'],
        ];
    }

    public function locality(Builder $builder, $value): void
    {
        $builder->where('locality_id', $value);
    }

    public function type(Builder $builder, $value): void
    {
        $builder->where('type', $value);
    }
}
