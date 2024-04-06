<?php

namespace App\Infrastructure\Database\Models\Filters\Place;

use App\Infrastructure\Database\Models\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class PlaceFilter extends AbstractFilter
{
    /**
     * @return array[]
     */
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

    /**
     * @param Builder $builder
     * @param array $value
     * @return void
     */
    public function locality(Builder $builder, array $value): void
    {
        $builder->whereHas('locality', function ($query) use ($value) {
            $query->whereIn('name', $value);
        });
    }

    /**
     * @param Builder $builder
     * @param array $value
     * @return void
     */
    public function type(Builder $builder, array $value): void
    {
        $builder->whereHas('type', function ($query) use ($value) {
            $query->whereIn('name', $value);
        });
    }

    /**
     * @param Builder $builder
     * @param array $value
     * @return void
     */
    public function rating(Builder $builder, array $value): void
    {
        $from = $value['from'];
        $to = $value['to'];

        $builder->withAvg('reviews', 'rating')
                ->having('reviews_avg_rating', '>=', $from)
                ->having('reviews_avg_rating', '<=', $to);
    }

    /**
     * @param Builder $builder
     * @param array $value
     * @return void
     */
    public function distance(Builder $builder, array $value): void
    {
        $from = $value['from'];
        $to = $value['to'];

        $builder->having('distance', '>=', $from)
            ->having('distance', '<=', $to);
    }

    /**
     * @param Builder $builder
     * @param array $value
     * @return void
     */
    public function sort(Builder $builder, array $value): void
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

    /**
     * @param Builder $builder
     * @param string $value
     * @return void
     */
    public function search(Builder $builder, string $value): void
    {
        $builder->where('name', 'like', "%$value%");
    }
}
