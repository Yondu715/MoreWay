<?php

namespace App\Infrastructure\Database\Models\Filters\Route;

use App\Infrastructure\Database\Models\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class RouteFilter extends AbstractFilter
{
    /**
     * @return array[]
     */
    protected function getCallbacks(): array
    {
        return [
            'rating' => [$this, 'rating'],
            'passing' => [$this, 'passing'],
            'search' => [$this, 'search'],
            'sort' => [$this, 'sort'],
            'point' => [$this, 'point'],
        ];
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
    public function point(Builder $builder, array $value): void
    {
        $from = $value['from'];
        $to = $value['to'];

        $builder->withCount('routePoints')
            ->having('route_points_count', '>=', $from)
            ->having('route_points_count', '<=', $to);
    }

    /**
     * @param Builder $builder
     * @param array $value
     * @return void
     */
    public function passing(Builder $builder, array $value): void
    {
        $from = $value['from'];
        $to = $value['to'];

        $builder->withCount(['routePoints' => function ($query) {
            $query->whereHas('progresses', function ($query) {
                $query->where('is_completed', true);
            });
        }])
            ->whereHas('routePoints', function ($query) use ($from, $to) {
                $query->where(function ($subquery) use ($from, $to) {
                    $subquery->whereIn('id', function ($innerQuery) use ($from, $to) {
                        $innerQuery->select('route_point_id')
                            ->from('user_route_progresses')
                            ->where('is_completed', true)
                            ->groupBy('route_point_id')
                            ->havingRaw('COUNT(DISTINCT user_id) BETWEEN ? AND ?', [$from, $to]);
                    });

                    if ($from == 0) {
                        $subquery->orWhereDoesntHave('progresses');
                    }
                });
            });
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

            case 'passing': {
                $builder->withCount(['routePoints' => function ($query) {
                    $query->whereHas('progresses', function ($query) {
                        $query->where('is_completed', true);
                    });
                }])
                    ->whereHas('routePoints', function ($query) {
                        $query->where(function ($subquery){
                            $subquery->whereIn('id', function ($innerQuery){
                                $innerQuery->select('route_point_id')
                                    ->from('user_route_progresses')
                                    ->where('is_completed', true)
                                    ->groupBy('route_point_id')
                                    ->havingRaw('COUNT(DISTINCT user_id)');
                            });
                            $subquery->orWhereDoesntHave('progresses');
                        });
                    })
                    ->orderBy('route_points_count', $value['sortType']);
            }

            case 'places': {
                $builder->withCount('routePoints')->orderBy('route_points_count', $value['sortType']);
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
