<?php

namespace App\Infrastructure\Database\Models\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class AbstractFilter implements FilterInterface
{
    /** @var array */
    private array $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    abstract protected function getCallbacks(): array;

    public function apply(Builder $builder): void
    {
        foreach ($this->getCallbacks() as $name => $callback) {
            if (isset($this->filters[$name])) {
                call_user_func($callback, $builder, $this->filters[$name]);
            }
        }
    }
}
