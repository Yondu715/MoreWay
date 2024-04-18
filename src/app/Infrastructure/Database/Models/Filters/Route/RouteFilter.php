<?php

namespace App\Infrastructure\Database\Models\Filters\Route;

use App\Infrastructure\Database\Models\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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

        //*rewrite to Eloquent
        $builder->withCount(['routePoints as total_route_points'])
            ->whereRaw('(SELECT COUNT(DISTINCT user_id)
                 FROM (
                     SELECT user_id, COUNT(DISTINCT route_point_id) as completed_points
                     FROM user_route_progresses
                     WHERE route_point_id IN (SELECT id FROM route_points WHERE route_id = routes.id)
                       AND is_completed = true
                     GROUP BY user_id
                     HAVING COUNT(DISTINCT route_point_id) = (SELECT COUNT(*) FROM route_points WHERE route_id = routes.id)
                 ) as completed_routes
                ) BETWEEN ? AND ?', [$from, $to]);
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

            //*rewrite to Eloquent
            case 'passing': {
                $builder->withCount(['routePoints as total_route_points'])
                    ->addSelect(['completed_users' => function ($query) {
                        $query->select(DB::raw('COUNT(*)'))
                            ->from(DB::raw('(SELECT user_id, COUNT(DISTINCT route_point_id) as completed_points
                            FROM user_route_progresses
                            WHERE route_point_id IN (
                                SELECT id FROM route_points WHERE route_id = routes.id
                            ) AND is_completed = true
                            GROUP BY user_id
                            HAVING COUNT(DISTINCT route_point_id) = (
                                SELECT COUNT(*) FROM route_points WHERE route_id = routes.id
                            )
                        ) as completed_routes'));
                    }])
                    ->orderBy('completed_users', $value['sortType']);
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
