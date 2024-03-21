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
            'rating' => [$this, 'rating'],
            'distance' => [$this, 'distance'],
            'search' => [$this, 'search'],
            'sort' => [$this, 'sort'],
        ];
    }

    public function locality(Builder $builder, $value): void
    {
        $builder->whereHas('locality', function ($query) use ($value) {
            $query->where('name', $value);
        });
    }

    public function type(Builder $builder, $value): void
    {
        $builder->whereHas('type', function ($query) use ($value) {
            $query->where('name', $value);
        });
    }

    public function rating(Builder $builder, $value): void
    {
        $from = $value['from'];
        $to = $value['to'];

        $builder->withAvg('reviews', 'rating')
                ->having('reviews_avg_rating', '>=', $from)
                ->having('reviews_avg_rating', '<=', $to);
    }

    public function distance(Builder $builder, $value): void
    {
        $from = $value['from'];
        $to = $value['to'];

        $builder->having('distance', '>=', $from)
            ->having('distance', '<=', $to);
    }

    public function sort(Builder $builder, $value): void
    {
        switch ($value['sort']){
            case 'rating': {
                $builder->withAvg('reviews', 'rating')
                    ->orderBy('reviews_avg_rating', $value['sortType']);
            }

            case 'comments': {
               $builder->withCount('reviews')
                    ->orderBy('reviews_count', $value['sortType']);
            }

            case 'time': {
                $builder->orderBy('created_at', $value['sortType']);
            }

            case 'distance': {
                if ($value['sort'] === 'distance') {
                    $builder->orderBy($value['sort'], $value['sortType']);
                }
            }
        }
    }

    public function search(Builder $builder, $value): void
    {
        $builder->where('name', 'like', "%{$value}%");
    }
}
