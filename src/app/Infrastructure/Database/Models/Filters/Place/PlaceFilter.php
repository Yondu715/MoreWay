<?php

namespace App\Infrastructure\Database\Models\Filters\Place;

use App\Infrastructure\Database\Models\Filters\AbstractFilter;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class PlaceFilter extends AbstractFilter
{

    private Closure $distanceCalculator;

    public function __construct(array $filters, Closure $distanceCalculator)
    {
        parent::__construct($filters);
        $this->distanceCalculator = $distanceCalculator;
    }

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
            ->havingRaw('COALESCE(reviews_avg_rating, 0) >= ?', [$from])
            ->havingRaw('COALESCE(reviews_avg_rating, 0) <= ?', [$to]);
    }

    /**
     * @param Builder $builder
     * @param array $value
     * @return void
     */
    public function distance(Builder $builder, array $value): void
    {
        $placesId = [];

        $builder->get()->map(function ($place) {
            $place->distance = call_user_func($this->distanceCalculator, [$place->lat, $place->lon]);
            return $place;
        })->filter(function ($place) use ($value, &$placesId) {
            if ($place->distance >= $value['from'] && $place->distance <= $value['to']) {
                $placesId[] = $place->id;
            }
            return $place->distance >= $value['from'] && $place->distance <= $value['to'];
        });

        $builder->whereIn('id', $placesId);
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
                $places = $builder->get()->map(function ($place) {
                    $place->distance = call_user_func($this->distanceCalculator, [$place->lat, $place->lon]);
                    return $place;
                });

                if ($value['sortType'] === 'asc') {
                    $places = $places->sortBy('distance');
                } else {
                    $places = $places->sortByDesc('distance');
                }

                $placesId = $places->pluck('id');

                $builder->orderByRaw('FIELD(id, ' . $placesId->implode(',') . ')');
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
        if(!in_array('%', str_split($value))) {
            $builder->where('name', 'like', "%$value%");
        }
        else{
            $builder->whereRaw('1 = 0');
        }
    }
}
