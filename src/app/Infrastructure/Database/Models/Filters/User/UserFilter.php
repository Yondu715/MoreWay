<?php

namespace App\Infrastructure\Database\Models\Filters\User;

use App\Infrastructure\Database\Models\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class UserFilter extends AbstractFilter
{
    /**
     * @return array[]
     */
    protected function getCallbacks(): array
    {
        return [
            'name' => [$this, 'name']
        ];
    }

    /**
     * @param Builder $builder
     * @param string $value
     * @return void
     */
    public function name(Builder $builder, string $value): void
    {
        if (!in_array('%', str_split($value))) {
            $builder->where('name', 'like', "%$value%");
        } else {
            $builder->whereRaw('1 = 0');
        }
    }


}