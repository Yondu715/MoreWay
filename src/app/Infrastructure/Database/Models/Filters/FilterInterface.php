<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\Filters;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    public function apply(Builder $builder);
}
