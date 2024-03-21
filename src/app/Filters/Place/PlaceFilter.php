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
            'search' => [$this, 'search'],
            'sort' => [$this, 'sort'],
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

    public function sort(Builder $builder, $value): void
    {
        switch ($value['sort']){
            case 'rating': {
                $builder->withAvg('reviews', 'rating')
                    ->orderBy('reviews_avg_rating', $value['sortType'])
                    ->get();
            }
            case 'comments' : {
               $builder->withCount('reviews')
                    ->orderBy('reviews_count', $value['sortType'])
                    ->get();
            }
            case 'time' : {
                $builder->orderBy('created_at', $value['sortType'])
                    ->get();
            }
        }
    }

    public function search(Builder $builder, $value): void
    {
        $builder->where('name', 'like', "%{$value}%");
    }
}
