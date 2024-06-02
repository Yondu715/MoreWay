<?php

namespace App\Infrastructure\Database\Models\Traits;

use App\Infrastructure\Database\Models\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

trait HasFilter
{
    /**
     * @param Builder $builder
     * @param FilterInterface $filter
     * @return Builder
     */
    public function scopeFilter(Builder $builder, FilterInterface $filter): Builder
    {
        $filter->apply($builder);

        return $builder;
    }
}
